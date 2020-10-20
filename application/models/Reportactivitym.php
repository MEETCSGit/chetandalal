<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
/**
 * Verification Document Model - Model
 *
 * @category  Model
 * @package   Models
 * @subpackage Report Activity
 * @author    Akshay Dusane <akshay.dusane@camplus.co.in>
 * @copyright 2017 Meetcs.com
 * @version   1.0.0
 */

class Reportactivitym extends CI_Model {
	/**
	 * Define the table name
	 *
	 * @var string
	 */
	private $_checklist_item = 'checklist_item';
	private $_checklist_check = 'checklist_check';
	private $_user = 'user';
	private $_course_modules = 'course_modules';
	private $_cdims_post_mail = 'cdims_post_mail';
	
	
	public function get_report_quiz_scorm(){

        /*working for GFSU course*/
		/*return $this->db->query(
			'	SELECT mcc.userid,mu.firstname,mu.lastname,mu.username,mu.email,from_unixtime(mu.lastlogin,"%Y-%m-%d") AS lastlogintime,
				ifnull((
                    select count(1)count FROM mdl_checklist_item mci
                    INNER JOIN mdl_course_modules mcm ON mci.moduleid = mcm.id
                    INNER JOIN mdl_checklist_check mcc ON mci.id = mcc.item
                    where  mcc.userid = mu.id and mcm.module=5 
                    having  count>0)
                       ,0)Rating,
				ifnull((
                    select count(1)count FROM mdl_checklist_item mci
                    INNER JOIN mdl_course_modules mcm ON mci.moduleid = mcm.id
                    INNER JOIN mdl_checklist_check mcc ON mci.id = mcc.item
                    where  mcc.userid = mu.id and mcm.module=7
                    having count >0)
                       ,0)Feedback,
                       
               (ROUND( ifnull((
                    SELECT count(1)count FROM mdl_checklist_item mci
                    INNER JOIN mdl_course_modules mcm ON mci.moduleid = mcm.id
                    INNER JOIN mdl_checklist_check mcc ON mci.id = mcc.item
                    WHERE mcm.module IN (16,18) AND mcc.usertimestamp != 0 AND mcc.userid = mu.id
                    GROUP BY mcc.userid
                    having count >0
                ),0)/(SELECT count(*)
from mdl_course_modules 
WHERE module IN (16,18)),2)*100)Activities,
				ifnull((
                    SELECT MAX(grade) 
                    FROM mdl_quiz_grades as mqg
                    WHERE quiz = 23 AND mqg.userid = mcc.userid
                ),0)Grades
				FROM mdl_checklist_check mcc
                INNER JOIN mdl_user mu ON mcc.userid = mu.id
				WHERE mu.deleted=0  
                AND from_unixtime(mu.lastlogin,"%Y-%m-%d") < DATE_SUB(curdate(), INTERVAL 2 WEEK)
				GROUP BY mcc.userid
                HAVING Grades = 0
                ORDER BY Grades DESC'
		)->result_array();*/

        /*working for GFSU course*/


        /*CFACI course*/

        return $this->db->query(
            'SELECT mue.userid,mu.firstname,mu.lastname,mu.username,mu.email,from_unixtime(mu.lastlogin,"%Y-%m-%d") AS lastlogintime,
                ifnull((
                    select count(1)count FROM mdl_checklist_item mci
                    INNER JOIN mdl_course_modules mcm ON mci.moduleid = mcm.id
                    INNER JOIN mdl_checklist_check mcc ON mci.id = mcc.item
                    where  mcc.userid = mu.id and mcm.module=5 and mcm.course = 10
                    having  count>0)
                       ,0)Rating,
                ifnull((
                    select count(1)count FROM mdl_checklist_item mci
                    INNER JOIN mdl_course_modules mcm ON mci.moduleid = mcm.id
                    INNER JOIN mdl_checklist_check mcc ON mci.id = mcc.item
                    where  mcc.userid = mu.id and mcm.module=7 and mcm.course = 10
                    having count >0)
                       ,0)Feedback,
                       
               (ROUND( ifnull((
                    SELECT count(1)count FROM mdl_checklist_item mci
                    INNER JOIN mdl_course_modules mcm ON mci.moduleid = mcm.id
                    INNER JOIN mdl_checklist_check mcc ON mci.id = mcc.item
                    WHERE mcm.module IN (16,18) AND mcc.usertimestamp != 0 AND mcc.userid = mu.id and mcm.course = 10
                    GROUP BY mcc.userid
                    having count >0
                ),0)/(SELECT count(*)
from mdl_course_modules 
WHERE module IN (16,18)),2)*100)Activities,
                ifnull((
                    SELECT MAX(grade) 
                    FROM mdl_quiz_grades as mqg
                    WHERE quiz = 23 AND mqg.userid = mcc.userid
                ),0)Grades
                FROM mdl_checklist_check mcc
                RIGHT JOIN mdl_user_enrolments mue ON mcc.userid = mue.userid 
                INNER JOIN mdl_user mu ON mue.userid = mu.id
                WHERE mu.deleted=0 AND mue.enrolid = 25
                AND from_unixtime(mu.lastlogin,"%Y-%m-%d") < DATE_SUB(curdate(), INTERVAL 2 WEEK)
                GROUP BY mue.userid
                HAVING Grades = 0
                ORDER BY Grades DESC'
        )->result_array();

        /*CFACI course*/
	}

	public function save_mail($data){
		return $this->db->insert_batch($this->db->dbprefix($this->_cdims_post_mail), $data);
	}	
}

?>