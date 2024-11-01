<?php
Namespace Skytells\SFA;
Class Reports {

  public static function UpdateDailyReports($Node, $Node2 = false, $Do = '+') {
    global $SFA, $wpdb;
    $dailyFormat = gmdate('Y-m-d');
    $Node = esc_sql($Node);
    $Node2 = esc_sql($Node2);
    
    $SQL = $SFA->db->rawQueryOne("SELECT * FROM {$wpdb->prefix}SFADailyReports WHERE DayFormat = '$dailyFormat'");
    if (isset($SQL['stamp'])) {
      if ($Node2 != false) {
        $SFA->db->rawQueryOne("UPDATE {$wpdb->prefix}SFADailyReports SET $Node = $Node $Do 1, $Node2 = $Node2 $Do 1 WHERE DayFormat = '$dailyFormat'");
      }else {
        $SFA->db->rawQueryOne("UPDATE {$wpdb->prefix}SFADailyReports SET $Node = $Node $Do 1 WHERE DayFormat = '$dailyFormat'");
      }
    }else {
        if ($Node2 != false) {
          $SFA->db->insert('SFADailyReports', ['DayFormat' => $dailyFormat, 'stamp' => getStamp(), $Node => 1, $Node2 => 1]);
        }else {
            $SFA->db->insert('SFADailyReports', ['DayFormat' => $dailyFormat, 'stamp' => getStamp(), $Node => 1]);
        }
    }
    return true;
  }

  public static function getGraphSummary() {
    global $SFA, $wpdb;
    $Data = $SFA->db->get('SFADailyReports', 7);

    return $Data;
  }

}
