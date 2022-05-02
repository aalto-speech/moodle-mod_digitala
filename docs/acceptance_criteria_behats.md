# Acceptance criteria and Behats

For acceptance testing, this plugin uses Behat, which is a PHP framework for automated functional testing. There are some additional Behats beyond the acceptance criteria mentioned in the product backlog. The criteria mentioned in the backlog can be found in following Behat-files:

| **Acceptance criteria**     | **Behat file** |
|-----------------------------|----------------|
| Student can see current progress in the assignment  | [navigation.feature](./../tests/behat/navigation.feature) |
| Student can see the phases of the whole assignment  | [navigation.feature](./../tests/behat/navigation.feature) |
| Student can see given assignment | [assignment.feature](./../tests/behat/assignment.feature) |
| Student can see given resources | [assignment.feature](./../tests/behat/assignment.feature) |
| Student can send answer for evaluation to Aalto ASR | [assignment.feature](./../tests/behat/assignment.feature) |
| Student can receive assessment from Aalto ASR | [assignment.feature](./../tests/behat/assignment.feature) |
| Student can start recording | [microphone.feature](./../tests/behat/microphone.feature)|
| Student can stop recording | [microphone.feature](./../tests/behat/microphone.feature)|
| Student can record with the microphone | [microphone.feature](./../tests/behat/microphone.feature)|
| Symbol indicates ongoing recoding | [microphone.feature](./../tests/behat/microphone.feature)|
| Student can listen test recording | [microphone.feature](./../tests/behat/microphone.feature)|
| Student can see numeric report | [report.feature](./../tests/behat/report.feature) |
| Student can see verbal feedback | [report.feature](./../tests/behat/report.feature) |
| Student can see transcript of the performance | [report.feature](./../tests/behat/report.feature) |
| Student sees indication of recording | [microphone.feature](./../tests/behat/microphone.feature)|
| Indication can show no recording ongoing | [microphone.feature](./../tests/behat/microphone.feature)|
| Indication can show recording ongoing | [microphone.feature](./../tests/behat/microphone.feature)|
| Teacher can create new assignment | [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature)|
| Teacher can give assignment name and question text | [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature) |
| Teacher can give resource text| [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature) |
| Student can see what each point in the report means| [report.feature](./../tests/behat/report.feature)|
| Teacher can remove assignment | [delete_activity.feature](./../tests/behat/delete_activity.feature)|
| Student can listen previous recording on the report page | [report.feature](./../tests/behat/report.feature) - tests that audio can be found |
| Student can pause previous recording on the report page | no Behats especially for this |
| Student can stop listening previous recording on the report page | no Behats especially for this|
| Student can override previous recording with new one | [assignment.feature](./../tests/behat/assignment.feature)|
| This function listens limit set by teacher: number of recording attempts | [assignment.feature](./../tests/behat/assignment.feature)|
| Teacher can edit existing assignment | [editdigitala.feature](./../tests/behat/editdigitala.feature) |
| Assignment resources do not disappear | [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature) |
| Teacher can add pictures, audio and video from online sources | [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature) |
| Teacher can add pictures, audio and video from file | [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature) |
| Student can see only own answers and feedback | no Behats especially for this |
| Student can see feedback form | [report.feature](./../tests/behat/report.feature) |
| Student can fill feedback from | [report.feature](./../tests/behat/report.feature) |
| Student can only record for given time | [assignment.feature](./../tests/behat/assignment.feature) |
| Student can only submit answer times given in the settings | [assignment.feature](./../tests/behat/assignment.feature) |
| Teacher can set limit in the activity settings | [createnewdigitala.feature](./../tests/behat/createnewdigitala.feature) |
| Teacher can see report given to student | [teacher_detail_report.feature](./../tests/behat/teacher_detail_report.feature) |
| Teacher can listen to student's recording | [teacher_detail_report.feature](./../tests/behat/teacher_detail_report.feature) |
| Teacher can give feedback to server's report | [teacher_report_feedback.feature](./../tests/behat/teacher_report_feedback.feature) |
| Teacher can edit report evaluation | [teacher_report_feedback.feature](./../tests/behat/teacher_report_feedback.feature) |
| Teacher can see list of students' tries | [teacher_overview_report.feature](./../tests/behat/teacher_overview_report.feature) |
| Student can not see a list of students' tries | [teacher_overview_report.feature](./../tests/behat/teacher_overview_report.feature) |
| Student can see timer | [assignment.feature](./../tests/behat/assignment.feature) |
| Student can see how long he/she has recorded | [assignment.feature](./../tests/behat/assignment.feature) |
| Teacher can delete attempts and thus reset attempt times for all students | [teacher_delete_attempt.feature](./../tests/behat/teacher_delete_attempt.feature) |
| Teacher can delete attempts and thus reset attempt times for selected students | [teacher_delete_attempt.feature](./../tests/behat/teacher_delete_attempt.feature) |
| Error handling for aalto server/connection issues and other errors | no Behats especially for this |
| Chart and feedback should be shown properly on mobile | Blocked, unfinished feature |
| Student can listen to examples of fluent speaker | Blocked, unfinished feature |
| Student can listen to examples of disfluent speaker | Blocked, unfinished feature |
| Teacher can see only assignments that created | no Behats especially for this |
| Teacher can see only assignments in which has rights | no Behats especially for this |
| Teacher can see state of student's assignment | [teacher_overview_report.feature](./../tests/behat/teacher_overview_report.feature) |
| Teacher can see if feedback is given | [teacher_detail_report.feature](./../tests/behat/teacher_detail_report.feature) |
| Teacher can export attempts as CSV| [teacher_overview_report.feature](./../tests/behat/teacher_overview_report.feature) |
| Teacher can export teacher report feedbacks as CSV| [teacher_overview_report.feature](./../tests/behat/teacher_overview_report.feature) |
| Admin can see list of assignments | no Behats especially for this |
| Admin can see student's tries on assignment | [teacher_detail_report.feature](./../tests/behat/teacher_detail_report.feature) |
| Admin can see more details about student's try | no Behats especially for this, unfinished feature |
| Admin has same priviledges as teacher | [delete_activity.feature](./../tests/behat/delete_activity.feature), [teacher_delete_attempt.feature](./../tests/behat/teacher_delete_attempt.feature), [teacher_report_feedback.feature](./../tests/behat/teacher_report_feedback.feature) |
| Admin has debug mode, that shows more about interaction with Aalto ASR | Blocked, unfinished feature |
| Admin can define groups | Blocked, unfinished feature |
| Admin can enable features by group | Blocked, unfinished feature |
| Admin can disable features by group | Blocked, unfinished feature |
| Student can change microphone settings | Blocked, unfinished feature |
| Find security problems and fix them | no Behats especially for this |
| Check for permissions in every feature | no Behats especially for this |




