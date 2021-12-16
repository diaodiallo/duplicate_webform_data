<?php

namespace Drupal\duplicate_webform_data;

use Drupal\duplicate_webform_data\Util\DuplicateWebformDataUtility;
use Drupal\group\Entity\Group;
use Drupal\node\entity\Node;

/**
 * Class DuplicateWebformDataService
 *
 * @package Drupal\duplicate_webform_data
 */
class DuplicateWebformDataService implements DuplicateWebformDataServiceInterface {

  private $duplicateWebformDataUtility;

  /**
   * Constructs a new ItDataPullingService object.
   */
  public function __construct() {
    $this->duplicateWebformDataUtility = new DuplicateWebformDataUtility();
  }

  public function duplicateData($webform_id, $tid) {
    $number = 0;
    $duplicateMapping = $this->duplicateWebformDataUtility->duplicateMapping();
    $groupMapping = $this->duplicateWebformDataUtility->groupMapping();

    $webform = \Drupal\webform\Entity\Webform::load($webform_id);
    if ($webform->hasSubmissions()) {
      $query = \Drupal::entityQuery('webform_submission')
        ->condition('webform_id', $webform_id);
      $result = $query->execute();
      foreach ($result as $item) {
        $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
        if ($submission->getData()['impact_team'] == $tid) {
          $duplicated = $submission->createDuplicate();
          $duplicated->setElementData('impact_team', $duplicateMapping[$tid]);
          $itId = $duplicated->getData()['impact_team'];
          $it = $this->duplicateWebformDataUtility->getTn($itId);
          $date = $duplicated->getData()['date_of_completion'];
          $month = substr($date, 5, 2);
          $month = mapMonths()[$month];
          $year = getTn($duplicated->getData()['year_review']);

          // Create the webform node.
          $node = Node::create([
            'type' => 'webform',
            'title' => 'IT Dependency Level Assessment ' . $it . ' - ' . $month . ' ' . $year,
            'webform' => ['target_id' => $duplicated->getWebform()->id()],
          ]);
          $node->save();

          // Alter the submission entity type and id
          $duplicated->set('entity_type', 'node');
          $duplicated->set('entity_id', $node->id());
          $duplicated->save();
          $number++;
          // Add the node to a group
          $gid = $groupMapping[$duplicateMapping[$tid]];
          $group = Group::load($gid);

          if (!is_null($group)) {
            $type = 'group_node:' . $node->getType();
            $relation = $group->getContentByEntityId($type, $node->id());
            if (!$relation) {
              $group->addContent($node, $type);
            }
          }
          else {
            \Drupal::messenger()
              ->addMessage(t('The team %it does not correspond to a group.', ['%it' => $it]));
          }
        }
      }
    }

    return $number;
  }

}