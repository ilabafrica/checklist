<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\LabLevel;
use App\Models\LabAffiliation;
use App\Models\LabType;
use App\Models\AuditType;
use App\Models\Assessment;
use App\Models\Section;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Note;
use App\Models\Country;
use App\Models\Lab;
class SliptaSeeder extends Seeder
{
    public function run()
    {
    	/* Users table */
    	$usersData = array(
            array(
                "username" => "admin1", "password" => Hash::make("password"), "email" => "admin1@slipta.org",
                "name" => "Echecklist Admin", "gender" => "0", "phone"=>"0722000000", "address" => "P.O. Box 59857-00100, Nairobi"
            ),
            array(
                "username" => "assessor1", "password" => Hash::make("password"), "email" => "test1@slipta.org",
                "name" => "Echecklist Assessor", "gender" => "0", "phone"=>"0729333333", "address" => "P.O. Box 1369-00200, Nairobi"
            ),
        );

        foreach ($usersData as $user)
        {
            $users[] = User::create($user);
        }
        $this->command->info('Users table seeded');
    	/* Permissions table */
        $permissions = array(
            array("name" => "all", "display_name" => "All"),
            array("name" => "create-audit", "display_name" => "Can create audit"),

            array("name" => "edit-audit", "display_name" => "Can edit audit"),
            array("name" => "create-lab", "display_name" => "Can create lab"),
            array("name" => "edit-lab", "display_name" => "Can edit lab"),
            array("name" => "create-user", "display_name" => "Can create user"),
            array("name" => "edit-user", "display_name" => "Can edit user"),
            array("name" => "complete-audit", "display_name" => "Can complete audit"),
            array("name" => "approve-audit", "display_name" => "Can approve audit"),
            array("name" => "export-excel", "display_name" => "Can export to excel"),
            array("name" => "export-audit", "display_name" => "Can export audit"),
            array("name" => "export-data", "display_name" => "Can export audit data"),
            array("name" => "import-data", "display_name" => "Can import audit data"),

            //managing permissions
            array("name" => "manage-facilities", "display_name" => "Can manage facilities"),
            array("name" => "manage-labs", "display_name" => "Can manage labs"),
            array("name" => "manage-users", "display_name" => "Can manage users"),
            array("name" => "manage-audit-config", "display_name" => "Can manage audit configuration"),
            array("name" => "manage-audits", "display_name" => "Can manage audits"),
            array("name" => "manage-access-controls", "display_name" => "Can manage access controls"),
            array("name" => "view-reports", "display_name" => "Can view reports")
        );
        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
        $this->command->info('Permissions table seeded');

        /* Roles table */
        $roles = array(
            array("name" => "Superadmin", "display_name" => "Overall Administrator"),
            array("name" => "Admin", "display_name" => "Administrator"),
            array("name" => "User", "display_name" => "General User"),
            array("name" => "Assessor", "display_name" => "Assessor"),
            array("name" => "Auditor", "display_name" => "Auditor"),
            array("name" => "Approver", "display_name" => "Approver")
        );
        foreach ($roles as $role) {
            Role::create($role);
        }
        $this->command->info('Roles table seeded');

        $role1 = Role::find(1);
        $permissions = Permission::all();

        //Assign all permissions to role administrator
        foreach ($permissions as $permission) {
            $role1->attachPermission($permission);
        }
        //Assign role Superadmin to all permissions
        User::find(1)->attachRole($role1);

        $role2 = Role::find(4);//Assessor

        //Assign technologist's permissions to role technologist
        $role2->attachPermission(Permission::find(2));
        $role2->attachPermission(Permission::find(3));
        $role2->attachPermission(Permission::find(8));
        //Assign role Assessor to second user
        User::find(2)->attachRole($role2);

        //Assign roles to the other users
        /* Lab Levels */
        $labLevels = array(
            array("name" => "National", "user_id" => "1"),
            array("name" => "Referral", "user_id" => "1"),
            array("name" => "Regional", "user_id" => "1"),
            array("name" => "Zonal", "user_id" => "1")
        );
        foreach ($labLevels as $labLevel) {
            LabLevel::create($labLevel);
        }
        $this->command->info('Lab levels table seeded');
        /* Lab Affiliations */
        $labAffiliations = array(
            array("name" => "Private", "user_id" => "1"),
            array("name" => "Research", "user_id" => "1")
        );
        foreach ($labAffiliations as $labAffiliation) {
            LabAffiliation::create($labAffiliation);
        }
        $this->command->info('Lab affiliations table seeded');
        /* SLMTA Lab Types */
        $labTypes = array(
            array("name" => "National", "user_id" => "1"),
            array("name" => "Non-Governmental Organization", "user_id" => "1"),
            array("name" => "Faith-based", "user_id" => "1")
        );
        foreach ($labTypes as $labType) {
            LabType::create($labType);
        }
        $this->command->info('SLMTA lab types table seeded');

        /* Audit Types */
        $auditTypes = array(
            array("name" => "SLIPTA", "description" => "SLIPTA Template", "user_id" => "1"),
            array("name" => "BAT", "description" => "BioSafety", "user_id" => "1"),
            array("name" => "TB", "description" => "Tuberculosis", "user_id" => "1")
        );
        foreach ($auditTypes as $auditType) {
            AuditType::create($auditType);
        }
        $this->command->info('Audit types table seeded');

        /* Countries */
        $countries = array(
            array('name' => 'Afghanistan', 'code' => '93', 'iso_3166_2' => 'AF', 'iso_3166_3' => 'AFG', 'capital' => 'Kabul', 'user_id' => '1'),
            array('name' => 'Albania', 'code' => '355', 'iso_3166_2' => 'AL', 'iso_3166_3' => 'ALB', 'capital' => 'Tirana', 'user_id' => '1'),
            array('name' => 'Antartica', 'code' => '672', 'iso_3166_2' => 'AQ', 'iso_3166_3' => 'ATA', 'capital' => 'Antartica', 'user_id' => '1'),
            array('name' => 'Algieria', 'code' => '213', 'iso_3166_2' => 'AZ', 'iso_3166_3' => 'AZA', 'capital' => 'Algiers', 'user_id' => '1'),
            array('name' => 'American Samoa', 'code' => '1', 'iso_3166_2' => 'AS', 'iso_3166_3' => 'ASM', 'capital' => 'Pago Pago', 'user_id' => '1'),
            array('name' => 'Andorra', 'code' => '376', 'iso_3166_2' => 'AD', 'iso_3166_3' => 'AND', 'capital' => 'Andorra la Vella', 'user_id' => '1'),
            array('name' => 'Angola', 'code' => '244', 'iso_3166_2' => 'AO', 'iso_3166_3' => 'AGO', 'capital' => 'Luanda', 'user_id' => '1'),
            array('name' => 'Kenya', 'code' => '254', 'iso_3166_2' => 'KE', 'iso_3166_3' => 'KEN', 'capital' => 'Nairobi', 'user_id' => '1')
        );
        foreach ($countries as $country) {
            Country::create($country);
        }
        $this->command->info('Countries table seeded');

        /* Laboratories */
        $labs = array(
            array('lab_type_id' => '2', 'name' => 'ASPE Medical Clinic', 'lab_number' => '0023', 'address' => 'P.O. Box 59857', 'postal_code' => '00100', 'city' => 'Nairobi', 'state' => 'Nairobi', 'country_id' => '8', 'fax' => '6007498', 'telephone' => '0703034000', 'email' => 'aspe@aspe.org', 'lab_level_id' => '1', 'lab_affiliation_id' => '1', 'user_id' => '1')
        );
        foreach ($labs as $lab) {
            Lab::create($lab);
        }
        $this->command->info('Laboratories table seeded');
        
        /* Assessments */
        $assessments = array(
            array("name" => "Baseline Audit", "description" => "", "user_id" => "1"),
            array("name" => "Midterm Audit", "description" => "", "user_id" => "1"),
            array("name" => "Exit Audit", "description" => "", "user_id" => "1"),
            array("name" => "Surveillance Audit", "description" => "", "user_id" => "1"),
            array("name" => "Internal Audit", "description" => "", "user_id" => "1")
        );
        foreach ($assessments as $assessment) {
            Assessment::create($assessment);
        }
        $this->command->info('Assessments table seeded');

        /* Answers */
        $answer_yes = Answer::create(array("name" => "Yes", "description" => "Yes(Y)", "user_id" => "1"));
        $answer_no = Answer::create(array("name" => "No", "description" => "No(N)", "user_id" => "1"));
        $answer_na = Answer::create(array("name" => "Not Applicable", "description" => "N/A", "user_id" => "1"));
        $answer_partial = Answer::create(array("name" => "Partial", "description" => "Partial(P)", "user_id" => "1"));
        
        $this->command->info('Answers table seeded');

        /* Notes */
        $note_intro = Note::create(array("name" => "1.0 Introduction", "description" => "<p>Medical laboratories have always played an essential role in determining clinical decisions and providing clinicians with information that assists in the prevention, diagnosis, treatment, and management of diseases in the developed world. Presently, the laboratory infrastructure and test quality for all types of clinical laboratories remain in nascent stages in most countries of Africa. Consequently, there is an urgent need to strengthen laboratory systems and services. The establishment of a process by which laboratories can achieve accreditation to international standards is an invaluable tool for countries to improve the quality of laboratory services.</p><p>In accordance with WHO's core functions of setting standards and building institutional capacity, WHO-AFRO has established the <strong>Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA)</strong> to strengthen laboratory systems of its Member States. The <strong>Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA)</strong> is a framework for improving quality of public health laboratories in developing countries to achieve ISO 15189 standards. It is a process that enables laboratories to develop and document their ability to detect, identify, and promptly report all diseases of public health significance that may be present in clinical specimens. This initiative was spearheaded by a number of critical resolutions, including Resolution AFR/RC58/R2 on Public Health Laboratory Strengthening, adopted by the Member States during the 58th session of the Regional Committee in September 2008 in Yaounde, Cameroon, and the Maputo Declaration to strengthen laboratory systems. This quality improvement process towards accreditation further provides a learning opportunity and pathway for continuous improvement, a mechanism for identifying resource and training needs, a measure of progress, and a link to the WHO-AFRO National Health Laboratory Service Networks.</p><p>Clinical, public health, and reference laboratories participating in the <strong>Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA)</strong> are reviewed bi-annually. Recognition is given for the upcoming calendar year based on progress towards meeting requirements set by international standards and on laboratory performance during the 12 months preceding the SLIPTA audit, relying on complete and accurate data, usually from the past 1-13 months to 1 month prior to evaluation.</p><p>The current checklist was updated through a technical expert review process to align it with the ISO 15189:2012 version of the standard.</p><hr><h4>2.0 Scope</h4><hr><p>This checklist specifies requirements for quality and competency aimed to develop and improve laboratory services to raise quality to established national standards. The elements of this checklist are based on ISO standard 15189:2007(E) and, to a lesser extent, CLSI guideline GP26-A4; Quality Management System: A Model for Laboratory Services; Approved Guideline—Fourth Edition.</p><p>Recognition is provided using a five star tiered approach, based on a bi-annual on-site audit of laboratory operating procedures, practices, and performance.</p><p>The inspection checklist score will correspond to the number of stars awarded to a laboratory in the following manner:<p><div class='table-responsive'><table class='table table-striped table-bordered table-hover'><tbody><tr><td><h4>No Stars</h4><p>(0 - 150 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(151 - 177 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(178 - 205 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(206 - 232 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(233 - 260 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(260 - 275 pts)</p><p><i>&ge; 95%</i></p></td></tr></tbody></table></div><p>A laboratory that achieves less than a passing score on any one of the applicable standards will work with the Regional Office Laboratory Coordinator to:</p><ul><li>Identify areas where improvement is needed.</li><li>Develop and implement a work plan.</li><li>Monitor laboratory progress.</li><li>Conduct re-testing where required.</li><li>Continue steps to achieve full accreditation.</li></ul><hr><h4>Parts of the Audit</h4><hr><p>This laboratory audit checklist consists of three parts:</p><h3>Part I: Laboratory Profile</h3><h3>Part II: Laboratory Audits<p><small>Evaluation of laboratory operating procedures, practices, and tables for reporting performance </small></p></h3><h3>Part III: Summary of Audit Findings<p><small>Summary of findings of the SLIPTA audit and action planning worksheet</small></p></h3>", "audit_type_id" => "1", "user_id" => "1"));
        $note_prelude = Note::create(array("name" => "Prelude", "description" => "<p>Laboratory audits are an effective means to 1) determine if a laboratory is providing accurate and reliable results; 2) determine if the laboratory is well-managed and is adhering to good laboratory practices; and 3) identify areas for improvement. </p><p>Auditors complete this audit using the methods below to evaluate laboratory operations per checklist items and to document findings in detail.</p><ul><li><strong>Review laboratory documents &nbsp;</strong>to verify that the laboratory quality manual, policies, Standard Operating Procedures (SOPs) and other manuals (e.g., safety manual) are complete, current, accurate, and annually reviewed.</li><li><strong>Review laboratory records: &nbsp;</strong>Equipment maintenance records; audit trails, incident reports, logs, personnel files, IQC records, EQA records</li><li><strong>Observe laboratory operations &nbsp;</strong>to ensure: <ul><li>Laboratory testing follows written policies and procedures in pre-analytic, analytic and post-analytic phases of laboratory testing;</li><li>Laboratory procedures are appropriate for the testing performed;</li><li>Deficiencies and nonconformities identified are adequately investigated and resolved within the established timeframe.</li></ul></li><li><strong>Ask open-ended questions &nbsp;</strong>to clarify documentation seen and observations made. Ask questions like, \"show me how...\" or \"tell me about...\" It is often not necessary to ask all the checklist questions verbatim. An experienced auditor can often learn to answer multiple checklist questions through open-ended questions with the laboratory staff.</li><li><strong>Follow a specimen through the laboratory &nbsp;</strong>from collection through registration, preparation, aliquoting, analyzing, result verification, reporting, printing, and post-analytic handling and storing samples to determine the strength of laboratory systems and operations.</li><li><strong>Confirm that each result or batch can be traced &nbsp;</strong>back to a corresponding internal quality control (IQC) run and that the IQC was passed. Confirm that IQC results are recorded for all IQC runs and reviewed for validation.</li><li><strong>Confirm PT results &nbsp;</strong>and the results are reviewed and corrective action taken as required.</li><li><strong>Evaluate the quality and efficiency of supporting work areas &nbsp;</strong>(e.g., phlebotomy, data registration and reception, messengers, drivers, cleaners, IT, etc).</li><li><strong>Talk to clinicians &nbsp;</strong>to learn the users' perspective on the laboratory's performance. Clinicians often are a good source of information regarding the quality and efficiency of the laboratory. Notable findings can be documented in the Summary and Recommendations section at the end of the checklist.</li></ul><hr><h4>AUDIT SCORING</h4><hr><p>This Stepwise Laboratory Quality Improvement Process Towards Accreditation Checklist contains 111 main sections (a total of 334 questions) for a total of 258 points. Each item has been awarded a point value of 2, 3, 4 or 5 points--based upon relative importance and/or complexity. Responses to all questions must be, \"yes\", \"partial\", or \"no\".</p><ul><li>Items marked \"yes\" receive the corresponding point value (2, 3, 4 or 5 points).<strong><u>All</u> elements of a question must be present in order to indicate \"yes\" for a given item and thus award the corresponding points.</strong><p><strong>NOTE:</strong> items that include \"tick lists\" must receive all \"yes\" and/or \"n/a\" responses to be marked \"yes\" for the overarching item.</p></li><li>Items marked <i>\"partial\"</i> receive 1 point.</li><li>Items marked <i>\"no\"</i> receive 0 points.</li></ul><p>When marking \"partial\" or \"no\", notes should be written in the comments field to explain why the laboratory did not fulfill this item to assist the laboratory with addressing these areas of identified need following the audit.</p><p>Where the checklist question does not apply, indicate as NA. Subtract the sum of the scores of all questions marked NA and subtract that sum of NAs from the total of 275. Since denominator has changed, the star status is then determined using % score.</p><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td colspan=\"2\"><strong>Audit Score Sheet</strong></td></tr><tr><td><i>Section</i></td><td><i>Total Points</i></td></tr><tr><td><strong>Section 1 &nbsp;<strong>Documents & Records</td><td><strong>28</strong></td></tr><tr><td><strong>Section 2 &nbsp;<strong>Management Reviews</td><td><strong>14</strong></td></tr><tr><td><strong>Section 3 &nbsp;<strong>Organization & Personnel</td><td><strong>22</strong></td></tr><tr><td><strong>Section 4 &nbsp;<strong>Client Management & Customer Service</td><td><strong>10</strong></td></tr><tr><td><strong>Section 5 &nbsp;<strong>Equipment</td><td><strong>35</strong></td></tr><tr><td><strong>Section 6 &nbsp;<strong>Evaluation and Audits</td><td><strong>15</strong></td></tr><tr><td><strong>Section 7 &nbsp;<strong>Purchasing & Inventory</td><td><strong>24</strong></td></tr><tr><td><strong>Section 8 &nbsp;<strong>Process Control</td><td><strong>32</strong></td></tr><tr><td><strong>Section 9 &nbsp;<strong>Information Management</td><td><strong>21</strong></td></tr><tr><td><strong>Section 10 &nbsp;<strong>Identification of Non Conformities, Corrective and Preventive Actions</td><td><strong>19</strong></td></tr><tr><td><strong>Section 11 &nbsp;<strong>Occurrence/Incident Management & Process Improvement</td><td><strong>12</strong></td></tr><tr><td><strong>Section 12 &nbsp;<strong>Facilities and Biosafety</td><td><strong>43</strong></td></tr><tr><td><strong>TOTAL SCORE<strong></td><td><strong>275</strong></td></tr></tbody></table></div><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td><h4>No Stars</h4><p>(0 - 150 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(151 - 177 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(178 - 205 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(206 - 232 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(233 - 260 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(261 - 275 pts)</p><p><i>&ge; 95%</i></p></td></tr></tbody></table></div>", "audit_type_id" => "1", "user_id" => "1"));
        $note_certification = Note::create(array("name" => "SLIPTA Certification", "description" => "<p><ol><li><strong>Test results are reported by the laboratory on at least 80% of specimens within the turnaround time specified (and documented) by the laboratory in consultation with its clients.</strong> <i>Turnaround time to be interpreted as time from receipt of specimen in laboratory until results reported.</li><li><strong>Validation or verification of test methods used by the laboratory.</strong></li><li><strong>Internal quality control (IQC) procedures are practiced for all testing methods used by the laboratory.</strong><br />Ordinarily, each test kit has a set of positive and negative controls that are to be included in each test run. These controls included with the test kit are considered internal controls, while any other controls included in the run are referred to as external controls. QC data sheets and summaries of corrective action are retained for documentation and discussion with auditor.</li><li><strong>The scores on the two most recent WHO AFRO approved proficiency tests are 80% or better.</strong><br />Proficiency test (PT) results must be reported within 15 days of panel receipt. Laboratories that receive less than 80% on two consecutive PT challenges will lose their certification until such time that they are able to successfully demonstrate achievement of 80% or greater on two consecutive PT challenges. Unacceptable PT results must be addressed and corrective action taken.<br /><i>NOTE: A laboratory that has failed to demonstrate achievement of 80% or greater on the two most recent PT challenges will not be awarded any stars, regardless of the checklist score they received upon audit.</i></li></ol></p><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td colspan=\"3\"><strong>Score on annual on-site inspection is at least 55%</strong> (at least 143 points):</td><td></td><td>%</td><td></td></tr><tr><td><h4>No Stars</h4><p>(0 - 150 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(151 - 177 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(178 - 205 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(206 - 232 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(233 - 260 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(261 - 275 pts)</p><p><i>&ge; 95%</i></p></td></tr><tr><td>Lead Auditor Signature</td><td colspan=\"2\"></td><td>Date</td><td colspan=\"2\"></td></tr></tbody></table></div><hr>SOURCES CONSULTED<hr><p>AS 4633 (ISO 15189) Field Application Document: 2009</p><p>Centers for Disease Control - Atlanta - Global AIDS Program. (2008). Laboratory Management Framework and Guidelines. Atlanta, GA: Katy Yao, PhD.</p><p>CLSI/NCCLS. <i>Application of a Quality Management System Model for Laboratory Services; Approved Guideline--Third Edition.</i> CLSI/NCCLS document GP26-A3. Wayne, PA: NCCLS; 2004. www.clsi.org</p><p>CLSI/NCCLS. <i>A Quality Management System Model for Health Care; Approved Guideline--Second Edition.</i> CLSI/NCCLS document HS01-A2. Wayne, PA: NCCLS; 2004. www.clsi.org</p><p>College of American Pathologists, USA. (2010). Laboratory General and Chemistry and Toxicology Checklists.</p><p>Guidance for Laboratory Quality Management System in the Caribbean - A Stepwise Improvement Process. (2012)</p><p>International Standards Organization, Geneva (2007) Medical Laboratories - ISO 15189: Particular Requirements for Quality and Competence, 2nd Edition</p><p>Ministry of Public Health, Thailand. (2008). Thailand Medical Technology Council Quality System Checklist.</p><p>National Institutes of Health, (2007, Feb 05). DAIDS Laboratory Assessment Visit Report. Retrieved July 8, 2008, from National Institutes of Health Web site: <a href=\"http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm\"> http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm</a></p><p>National Institutes of Health, (2007, Feb 05). Chemical, Laboratory: Quality Assurance and Quality Improvement Monitors. CHECKLIST FOR SITE SOP REQUIRED ELEMENTS, Retrieved July 8, 2008, from <a href=\"http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm\">http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm</a> </p><p>National Institutes of Health, (2007, Feb 05). Laboratory: Chemical, Biohazard and Occupational Safety, Containment and Disposal. CHECKLIST FOR SITE SOP REQUIRED ELEMENTS, Retrieved July 8, 2008, from <a href=\"http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm\">http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm</a></p><p>PPD, Wilmington, North Carolina, (2007). Laboratory Report.</p><p>South African National Accreditation System (SANAS). (2005). Audit Checklist, SANAS 10378:2005.</p><p>USAID Deliver Project. The Logistics Handbook. (2007). Task Order 1.</p>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 1
        $note_legalEn = Note::create(array("name" => "Legal Entity", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.2</strong> The laboratory or the organization of which the laboratory is a part shall be an entity that can be held legally responsible for its activities. <strong>Note: Documentation could be in the form of a National Act, Company registration certificate, License number or Practice numb er.</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labQM = Note::create(array("name" => "Laboratory Quality Manual", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.3 and 4.2.2.2 and 4.3<br /> Note:</strong> A quality manual must be available that summarizes the laboratory’s quality management system, which includes policies that a ddress all areas of the laboratory service, and identifies the goals and objectives of the quality management system. The quality manual must include policies and make reference to processes and procedures for all areas of the laboratory service and must address all the clauses of ISO15189:2012.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docInfoControl = Note::create(array("name" => "Document and Information Control System", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3<br /> Note:</strong> There must be a procedure on document control. A document control system must be in place to ensure that records and all documents (internal and external) are current, read and understood by personnel, approved by authorized persons, reviewed periodically and revised as required. Documents must be uniquely identified to include title, page numbers, and authority of issue, document number, versions</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docRec = Note::create(array("name" => "Documents and Records", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3<br /> Note:</strong> Documents to be included on the list include Manuals, Procedures, and Processes. Work instructions. Forms, external documents.. The list could be in the form of a document master index, document log or document register. “Edition” can be regarded as synonymous with “revision or version” number for the documents.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_poSops = Note::create(array("name" => "Laboratory Policies and Standard Operating Procedures", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3 and 5.5<br /> Note:</strong> The laboratory must define who is authorized to approve documents for its intended use. The approver should not be the author but can be the reviewer.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_ethCon = Note::create(array("name" => "Ethical Conduct", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.3<br /> Note:</strong> Laboratories shall uphold the principle that the welfare and interest of the patient are paramount and patients should be tre ated fairly and without discrimination</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docuCon = Note::create(array("name" => "Document Control", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3 and 4.13<br /> Note:</strong> Documents that should be considered for document control are those that may vary based on changes in versions or time. Examples include policy statements, instructions for use, flow charts, procedures, specifications, forms, calibration tables, biological reference intervals and their origins, charts, posters, notices, memoranda, software documentation, drawings, plans, agreements, and documents of external origin such as regulations, standards and text books from which examination procedures are taken.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        
        $note_contRec = Note::create(array("name" => "Control of Records", "description" => "<i><small><strong>ISO15189 :2012 Clause 4.13<br /> Note:</strong> Records can be in any form or type of medium providing they are readily accessible and protected from unauthorized alterations. Legal liability concerns regarding certain types of procedures (e.g. histology examinations, genetic examinations, pediatric examinations) may require the retention of certain records for much longer periods than for other records. For some records, especially those stored electronically, the safest storage may be on secure media and an offsite location. Type of records will include but not be limited to quality records, technical records, personnel records, test request and results records.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_intExtComm = Note::create(array("name" => "Communication", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.6 and 4.14<br /> Note:</strong> Laboratory management must ensure that appropriate communication processes are established between the laboratory and its stakeholders and that communication takes place regarding the effectiveness of the laboratory’s pre-examination, examination and post-examination processes and quality management system.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_servAgr = Note::create(array("name" => "Service Agreements", "description" => "<i><small><strong>ISO15189:2012 Clause 4.4.1 and 5.4<br /> Note:</strong> By accepting a requisition form from an authorized requester, the laboratory is considered to have entered into a service agr eement. Customers and users may include clinicians, health care organizations, third party payment organizations or agencies, pharmaceutical companies, and patients.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_reffLabs = Note::create(array("name" => "Examination by Referral Laboratories", "description" => "<i><small><strong>ISO15189:2012 Clause 4.5 and 5.8 and 4.13<br /> Note:</strong> The laboratory must have a documented procedure for selecting and evaluating referral laboratories and consultants who provide opinions as well as interpretation for complex testing in any discipline.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_exServSupp = Note::create(array("name" => "External Services Supplier", "description" => "<i><small><strong>ISO15189:2012 Clause 4.6 and 5.3<br />Note:</strong> The laboratory must have a documented procedure for the selection and purchasing of external services, equipment, reagents and consumable supplies that affect the quality of its service.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_purInvCon = Note::create(array("name" => "Purchasing and Inventory Control", "description" => "<i><small><strong>ISO15189 :2012 Clause 4.6 and 5.3.2<br />Note:</strong> The laboratory shall have a documented procedure for the reception, storage, acceptance testing and inventory management of reagents and consumables.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_adServ = Note::create(array("name" => "Advisory Services", "description" => "<i><small><strong>ISO15189:2012 Clause 4.7<br />Note:</strong> The laboratory must have a system in place for providing advise to its users.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_resCompFeed = Note::create(array("name" => "Resolution of Complaints and Feedback", "description" => "<i><small><strong>ISO15189:2012 Clause 4.8 and 4.10<br />Note:</strong> The laboratory must have a documented procedure for the management of complaints or other feedback received from clinicians, patients, laboratory staff or other parties. Records shall be maintained of all complaints and their investigation and the action taken</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_nc = Note::create(array("name" => "Control of Nonconformities", "description" => "<i><small><strong>ISO15189:2012 Clause 4.9<br />Note:</strong> Nonconforming examinations or activities occur in many different areas and can be identified in many different ways, including clinician co mplaints, internal quality control indications, and instrument calibrations, checking of consumable materials, inter -laboratory comparisons, staff comments, reporting and certificate checking, laboratory management reviews, and internal and external audits.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_corAct = Note::create(array("name" => "Corrective Action", "description" => "<i><small><strong>ISO15189:2012 Clause 4.10<br />Note:</strong> Action taken at the time of the nonconformity to mitigate effects is considered immediate action. Only action taken to remo ve the root cause of the problem that is causing the Non Conformities is considered “corrective” action. Any immediate action taken must also be documented. Corrective actions must be appropriate to the effects of the nonconformities encountered.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_prevAct = Note::create(array("name" => "Preventive Action", "description" => "<i><small><strong>ISO15189 :2012 Clause 4.11<br />Note:</strong> Preventive action is a proactive process for identifying opportunities for improvement rather than a reaction to the  identification of problems or complaints (i.e. nonconformities).  In addition to review of the operational procedures, preventive action might involve analysis of data, including trend and ri sk analyses and external quality assessment (proficiency testing). The laboratory shall determine action to eliminate the causes of potential nonconformities in order to prevent  their occurrence. Preventive actions shall be appropriate to the effects of the potential problems.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_conImp = Note::create(array("name" => "Continual Improvement", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.2; 4.12; 4.14.5<br />Note:</strong> Improvement activities must be identified within the pre-examination, examination and post-examination processes. Laboratory management shall ensure that the laboratory participates in continual improvement activities that encompass relevant areas and outcomes of patient care.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_conRec = Note::create(array("name" => "Control Records", "description" => "<i><small><strong>ISO15189 :2012 Clause 4.13<br />Note:</strong> Records can be in any form or type of medium providing they are readily accessible and protected from unauthorized alteration s.  .Legal liability concerns regarding certain  types of procedures (e.g. histology examinations, genetic examinations, pediatric examinations) may require the retention of  certain records for much longer periods than for other records.  For some records, especially those stored electronically, the safest storage may be on secure media and an offsite location. Type of records will include but not be limited to quality records, technical records, personnel records, test request and  results records.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_inAud = Note::create(array("name" => "Internal Audits", "description" => "<i><small><strong>ISO15189:2012 Clause 4.14.5<br />Note:</strong> The cycle for internal auditing should normally be completed in one year. It is not necessary that internal audits cover each  year, in depth, all elements of the quality management system. The laboratory may decide to focus on a particular activity without  completely neglecting the  others.  The laboratory shall conduct internal  audits  at  planned  intervals  to  determine  whether  all  activities  in  the  quality   management  system,  including  pre-examination,  examination,  and  postexamination.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_riskMan = Note::create(array("name" => "Risk Management", "description" => "<i><small><strong>ISO15189:2012 Clause 4.14.5<br />Note:</strong> The cycle for internal auditing should normally be completed in one year. It is not necessary that internal audits cover each  year, in depth, all elements of the quality management system. The laboratory may decide to focus on a particular activity without  completely neglecting the  others.  The laboratory shall conduct internal  audits  at  planned  intervals  to  determine  whether  all  activities  in  the  quality   management  system,  including  pre-examination,  examination,  and  postexamination.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_manRev = Note::create(array("name" => "Management Review", "description" => "<i><small><strong>ISO15189:2012 Clause 4.15<br />Note:</strong> Laboratory management shall review the quality management system at planned intervals to ensure its  continuing suitability, adequacy and effectiveness and support of patient care.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_perMan = Note::create(array("name" => "Personnel Management", "description" => "<i><small><strong>ISO15189:2012 Clause 5.1.1; 5.1.9; 4.13<br />Note:</strong> The laboratory must have a documented procedure for personnel management and maintain records for all personnel to indicate compliance with requirements.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_perTra = Note::create(array("name" => "Personnel Training", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4 and 5.1.5<br />Note:</strong> Training includes external and internal trainings. The effectiveness of the training programme must be periodically reviewed.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_compAssess = Note::create(array("name" => "Competency Assessment", "description" => "<i><small><strong>ISO15189 :2012 Clause 4.1.1.4 and 4.4 and 5.1.6<br />Note:</strong> Competency could be assessed using a combination of some or all of the following methods: direct observation; monitoring and the recording of examination results; review of work records; problem solving skills; blinded samples, review of accumulative IQC a nd EQA. Competency assessment for professional judgment should be designed as specific and fit for purpose.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_auth = Note::create(array("name" => "Authorization", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2<br />Note:</strong> Authorization may be in the form of a Job description, letter of appointment, approved authority matrix etc.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_staPerf = Note::create(array("name" => "Staff Performance Review", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.1 and 5.1.7<br />Note:</strong> In addition to the assessment of technical competence, the laboratory management must ensure that reviews of staff performance consider the needs of the laboratory and of the individual in order to maintain or improve the  quality of service given to the users and encourage productive working relationships. Staff performing reviews should receive appropriate training.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_envCon = Note::create(array("name" => "Accommodation and Environmental Conditions", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4 and 5.2; 5.2.6<br />Note:</strong> The laboratory must have space allocated for the performance of its work that is designed to ensure the quality, safety and efficacy of the service provided to the users and the health and safety of laboratory personnel,  patients and visitors. The laboratory shall evaluate and determine the sufficiency and adequacy of the space allocated for the performance of the work. Evaluating and determining the sufficiency and adequacy of space may be done during internal audits, risk assessments or at management review meeting, however it must be documented that it was evaluated and found to be adequate.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labEquip = Note::create(array("name" => "Laboratory Equipment", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.1; 5.3.1.3<br />Note:</strong> For the purposes of this checklist, laboratory equipment includes hardware and software of instruments, measuring systems, an d laboratory information systems. The laboratory shall have a documented procedure for the selection, purchasing and management of  equipment.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_calEquip = Note::create(array("name" => "Calibration of Equipment", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.4<br />Note:</strong> The laboratory must have a documented procedure for the calibration of equipment that directly  or indirectly affects examination results. Documentation of calibration traceability to a higher order reference material or reference procedure may be provided by an examination system  manufacturer. Such documentation is acceptable as long as the manufac turer's examination system and calibration procedures are used without modification .</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_preExPro = Note::create(array("name" => "Pre-examination Process", "description" => "<i><small><strong>ISO15189:2012 Clause 5.4; 5.4.1; 5.4.3; 5.4.4.1; 5.4.5; 5.4.6; 5.4.7<br />Note:</strong> The laboratory must have documented procedures and information for pre-examination activities to ensure the validity of the results of examinations.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_valVer = Note::create(array("name" => "Validation and Verification of Equipment", "description" => "<i><small><strong>ISO15189:2012 Clause 5.5.1.2; 5.6.4 and 5.5.1.3<br />Note:</strong> Validations should be done on a) non-standard methods; b) laboratory designed or developed methods; c) standard methods used  outside their intended scope; d) validated methods subsequently modified. Verification is performed on methods that are being used without any modifications and i s a process of evaluating of whether or not the procedure meets the performance characteristics stated by the manufacturer i.e. the manufacturer validation claims. The performance characteristics are obtained from the manufacture (validation reports) or fr om package inserts. Comparison of different methods used for same tests is ongoing verification. The frequency and characteristics to be checked in ongoing verification must be clearly defined. <br /><strong>Note:</strong> All procedures or equipment used as backup must also be validated/verified as relevant.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_meUnc = Note::create(array("name" => "Measurement Uncertainity", "description" => "<i><small><strong>ISO15189:2012 Clause 5.5.1.4<br />Note:</strong> Uncertainty of measurement is used to indicate the confidence we have that the reported figure is correct. Uncertainty of measurement may be calculated using the calculated CV of at least 30 sets of internal QC data: CV% x 2 = Uncertainty of measurement (UM). The laboratory shall calculate the UM for all quantitative tests. These shall only be reported to clinicians if they request for them. For well-established methods, it is recommended a minimum of six months internal QC data should be used to calculate UM, updated at least annually where possible. For new methods at least 30 data points for each level of QC across at least two different batches of calibrator and reagents should be used to provide an interim estimat e of uncertainty of measurement.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_bioRef = Note::create(array("name" => "Biological Reference", "description" => "<i><small><strong>ISO15189:2012 Clause 5.5.2<br />Note:</strong> The laboratory shall define the biological reference intervals or clinical decision values, document the basis for  the reference intervals or decision values and communicate this information to users.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docExPro = Note::create(array("name" => "Documentation of examination procedures", "description" => "<i><small><strong>ISO15189:2012 Clause 5.5.3;<br />Note:</strong> Working instructions, card files or similar systems that summarize key  information are acceptable for use as a quick reference at the workbench, provided that a fully  documented procedure is available for reference.  Information from product instructions for use may be incorporated into examination procedures by reference in the SOP.  The minimum requirements for a technical SOP should be a) purpose of the examination; b) principle and method of the procedure used for examinations; c) type of sample; d) required equipment and reagents; e) environmental and safety controls; f) pr ocedural steps; g) interferences (e.g. lipemia, hemolysis, bilirubinemia, drugs) and cross reactions; h) principle of procedure for calculating results; i) laboratory clinic al interpretation; j) potential sources of variation; k) references.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labContPlan = Note::create(array("name" => "Laboratory Contingency Plan", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4; 5.2; 5.3.1; 5.10<br />Note:</strong> the laboratory should maintain sufficient replacement parts to minimize testing downtime (e.g. pipette components, microscope  bulbs and fuses, safety caps or buckets for safety centrifuge). Contingency plans should be periodically tested. Where the laboratory uses another laboratory as a backup, the performance of the back-up laboratory shall be regularly reviewed to ensure quality results</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_quaCon = Note::create(array("name" => "Quality Control and Assurance", "description" => "<i><small><strong>ISO15189:2012 Clause 4.10; 5.6; 5.6.2.1; 5.6.2.3; 5.6.3.1<br />Note:</strong> The laboratory should choose concentrations of control materials, wherever possible, especially at or near clinical decision  values, which ensure the validity of decisions made. Use of independent third party control materials should be considered, either instead of, or in addition to, any control materials supplied by the reagent or instrument manufacturer. EQA should cover the pre-examination process, examination process and post examination process. Where an EQA program is not available, the laboratory can use alternative methods with clearly defined acceptable results e.g. exchange of samples with other labs, testing certifi ed materials, sample previously tested. All procedures or equipment used as backup must also be included in EQA programme.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_repRes = Note::create(array("name" => "Reporting and Release of Results", "description" => "<i><small><strong>ISO15189:2012 Clause 5.8.1; 5.9.1<br />Note:</strong> Reports may be issued as a hard copy or electronically, all results issued verbally must be followed by a final report. The results of each examination must be reported accurately, clearly, unambiguously and in accordance with  any specific instructions in the examination procedures. The laboratory must define the format and medium of the report (i.e. electronic or paper) and the manner in which it is to be communicated from the laboratory.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_lis = Note::create(array("name" => "Laboratory Information System", "description" => "<i><small><strong>ISO15189:2012 Clause 5.10<br />Note:</strong> information systems includes the management of data and information contained in both computer and non -computerized systems. Some of the requirements may be more applicable to computer systems than to non -computerized systems. Computerized systems can include those integral to the functioning of laboratory equipment and stand-alone systems using generic software, such as word processing, spreadsheet and database applications that generate, collate, report and archive patient information and reports.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labSaMan = Note::create(array("name" => "Laboratory Safety Manual", "description" => "<i><small><strong>ISO15190:2013 Clause 4.1.1.4; 5.2<br />Note:</strong> Laboratory management must implement a safe laboratory environment in compliance with good pract ice and applicable requirements.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_poSopsAcc = Note::create(array("name" => "Policy and SOPs Accessibility", "description" => "<i><small><strong>ISO15189:2012 Clause 4.2.2.1; 4.3; 5.5<br />Note:</strong> All documentation must be current and approved by an authorized person.  The documentation can be in any form or type of medium, providing it is readily accessible and protected from unauthorized changes and undue deterioration</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_poSopsComm = Note::create(array("name" => "Policies and SOPs Communication", "description" => "<i><small><strong>ISO15189:2012 Clause 4.2.2.2; 5.1.5(b)<br />Note:</strong> The lab must have a system in place to ensure all staff are aware of the contents of all documents. All laboratory staff shall have access to and be instructed on the use and application of the quality manual and the referenced documents.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docContLog = Note::create(array("name" => "Document Control Log", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3<br />Note:</strong> Current authorized editions and their distribution are identified by means of a list (e.g. document register, log or master index).</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_discPoSops = Note::create(array("name" => "Discontinued Policies and SOPs", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3<br />Note:</strong> Obsolete controlled documents are dated and marked as obsolete. At least one copy of an obsolete controlled document is retained for a specified time period or in accordance with applicable specified requirements.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_dataFiles = Note::create(array("name" => "Data Files", "description" => "<i><small><strong>ISO15189:2012 Clause 4.3; 4.13<br />Note:</strong> Copies or files of results should be archived. The retention period may vary; however, the reported results shall be retrieva ble for as long as medically relevant or as required by national, regional or local authorities.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_arcRes = Note::create(array("name" => "Archived Results Accessibility", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13<br />Note:</strong> Records can be in any form or type of medium providing they are readily accessible and protected from unauthorized alterations. Archived patient results must be easily, readily and completely retrievable within a timeframe consistent with patient care needs.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 2
        $note_quaTecRec = Note::create(array("name" => "Routine Review", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4; 4.2.1<br />Note:</strong> There must be documentation that the laboratory manager/supervisor or a designee reviews and monitors the quality programme regularly. This routine review must ensure that recurrent problems have been addressed, and that new or redesigned activities have been evaluated.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_revOut = Note::create(array("name" => "Review Output", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4; 4.15.2;  4.15.4<br />Note:</strong> The interval between management reviews should be no greater than 12 months; however, shorter intervals should be adopted when a quality management system is being established.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_mrComm = Note::create(array("name" => "MR Communication", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4; 4.15.4<br />Note:</strong> Findings and actions arising from management reviews shall be recorded and reported to laboratory staff.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_mrComp = Note::create(array("name" => "MR Completed", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4; 4.15.4<br />Note:</strong> Laboratory management shall ensure that actions arising from management review are completed within a  defined timeframe.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 3
        $note_duRoDa = Note::create(array("name" => "Duty Roster And Daily Routine", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(c); 4.1.2.1(i)<br />Note:</strong> A duty roster designates specific laboratory personnel to specific workstations. Daily routines should be prioritized, organized and coordinated to achieve optimal service delivery for patients.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_orgChart = Note::create(array("name" => "Organizational Chart and External/Internal Reporting Systems", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.5<br />Note:</strong> An up-to-date organizational chart and/or narrative description should be available detailing the external and internal reporting relationships for laboratory personnel. The organizational chart or narrative should clearly show how the laboratory is linked to the rest of t he hospital and laboratory services where applicable.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labDir = Note::create(array("name" => "Lab Director", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4<br />Note:</strong> a director may be a person(s) with responsibility for, and authority over, a laboratory. The person or persons referred to may be designated collectively as laboratory director. Other settings may not use the term “Lab Director” but in this question, it refers to person/persons that are running the lab oratory, however they decide to name them</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qmsOversight = Note::create(array("name" => "Quality Management System Oversight", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.7<br />Note:</strong> There should be a quality manager (however named) with delegated authority to oversee compliance with the requirements of the  quality management system. The quality manager must report directly to the level of laboratory management at which decisions are m ade on laboratory policy and resources.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_perFiSys = Note::create(array("name" => "Personnel Filing System", "description" => "<i><small><strong>ISO15189:2012 Clause 5.1.9<br />Note:</strong> Personnel files must be maintained for all current staff. Wherever (offsite or onsite) and however the records are kept, the records must be  easily accessible when required. In some laboratories, not all records may be kept in a single file in one place e.g.  training and competency records should be kept in the laboratory, medically related information with the administration .</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_staffCompetency = Note::create(array("name" => "Staff Competency audit and Training", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.1(h); 5.1.6<br />Note:</strong> Newly hired lab staff must be assessed for competency before performing independent duties. All lab staff must undergo ongoing competency at a frequency defined by the laboratory. Staff assigned to a new section should be assessed before fully assuming in dependent duties. When deficiencies are noted, retraining and reassessment must be planned and documented. If the employee’s competency remains below standard, further action might includ e supervisory review of work, re-assignment of duties, or other appropriate actions. Records of competency assessments and resulting actions should be retained in personnel files and/or quality records. Records should show which skills were assessed, how those skills were measured, and who performed the assessment.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labStaffTra = Note::create(array("name" => "Laboratory Staff Training", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(c); 5.1.5<br />Note:</strong> The effectiveness of the training program shall be reviewed regularly. Personnel that are undergoing training shall be supervised at all times.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_staffMeet = Note::create(array("name" => "Staff Meetings", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.1(a); (e); 4.1.2.2; 4.1.2.6; 4.4; 4.14.3<br />Note:</strong> The laboratory should hold regular staff meetings to ensure communication within the laboratory. Meetings should have recorde d notes to facilitate review of progress over time.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 4
        $note_adviceTra = Note::create(array("name" => "Advice and Training by Qualified Staff", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(g); 4.7<br />Note:</strong> Authorized staff should provide advice on sample type, examination choice, frequency and results interpretation.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_resComp = Note::create(array("name" => "Resolution of Complaints", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(m); 4.8; 4.15.2(i)<br />Note:</strong> The laboratory must have a documented procedure for the management of complaints or other feedback  received from clinicians, patients, laboratory staff or other parties. Feedback must be given to the complainant.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labHandbook = Note::create(array("name" => "Laboratory Handbook for Clients", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(g); 4.5; 5.4.2<br />Note:</strong> The laboratory should provide its clients with a handbook that outlines the laboratory’s hours of operation, available tests, spe cimen collection instructions, packaging and shipping directions, and expected turnaround times.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_commOnDelays = Note::create(array("name" => "Communication Policy on Delays in Service ", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.6; 4.4; 5.8.1<br />Note:</strong> There must be a policy for notifying the requester when an examination is delayed. Such notification must be documented for b oth service interruption and resumption as well as related feedback from clinicians. Clinical personnel must be notified of all de lays of examinations.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_evalTool = Note::create(array("name" => "Evaluation Tool and Follow up", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(m); 4.8; 4.14.3; 4.14.4<br />Note:</strong> The laboratory should measure the satisfaction of clients, clinicians and patients regarding its services, either on an ongoi ng basis or through episodic solicitations.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 5
        $note_properEquip = Note::create(array("name" => "Adherence to Proper Equipment Protocol", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.2<br />Note:</strong> Equipment should be properly placed as specified in user manual away from the following but not limited to water, direct sunlight, vibrations,  in traffic and with more than 75% of the base of the equipment sitting on the bench top to avoid tip-over.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equiOper = Note::create(array("name" => "Equipment Operated by Trained Personnel", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.3<br />Note:</strong> The staff must be trained, and deemed competent to operate equipment</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipMethVal = Note::create(array("name" => "Equipment and Method Validation/ Verification and Documentation", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.2; 5.5.1<br />Note:</strong> Newly introduced methods or equipment must be verified onsite to ensure that their introduction yields performance equal to o r better than the previous method or equipment. Manufacturers’ validation may be used. Back up equipment must also be included in verification procedures.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_meQuaTests = Note::create(array("name" => "Measured Quantity Tests", "description" => "<i><small><strong>ISO15189:2012 Clause 5.5.1.4<br />Note:</strong> Measurement of uncertainty should be calculated at different clinical decision levels. Cumulative IQC (minimum 6 months data) may be used to calculate measurement of uncertainty.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipRecMain = Note::create(array("name" => "Equipment Record Maintenance", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.7<br />Note:</strong> Records must be maintained for each item of equipment used in the performance of examinations. Such equipment list must inclu de major analysers as well as ancillary equipment like centrifuges, water baths, rotators, fridges, pipettes, timers, printers, and computers.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipManRec = Note::create(array("name" => "Equipment Maintenance Records", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.5; 5.3.1.7<br />Note:</strong> Maintenance records must be maintained for each item of equipment used in the performance of examinations. These records sha ll be maintained and shall be readily available for the lifespan of the equipment or for any time period required by national, reg ional and local authorities.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_defEquip = Note::create(array("name" => "Defective Equipment waiting Repair", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.5<br />Note:</strong> label should include the date of malfunction and “not in use” and a signature of approval.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_obsoEquiPro = Note::create(array("name" => "Obsolete Equipment Procedures", "description" => "<i><small><strong>ISO15189:2012  Clause 4.13; 5.3.1.5<br />Note:</strong> Label should include the date made obsolete and “obsolete” and a signature of approval.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipCalibPro = Note::create(array("name" => "Adherence to Equipment Calibration Protocol", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.4<br />Note:</strong> Documentation of calibration traceability to a higher order reference material or reference procedure may be provided by an examination system manufacturer. Such documentation is acceptable as long as the manufacturer's examination system and calibration procedures ar e used without modification.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipPreMain = Note::create(array("name" => "Equipment Preventive Maintenance", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.5<br />Note:</strong> Preventative maintenance by operators must be done on all equipment used in examinations including centrifuges, autoclaves, m icroscopes, and safety cabinets.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipSerMain = Note::create(array("name" => "Equipment Service Maintenance", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.5<br />Note:</strong> All equipment must be serviced at specified intervals by a qualified service engineer either through service contracts or oth erwise. Service schedule must at minimum meet manufacturer’s requirements.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipMalf = Note::create(array("name" => "Equipment Malfunction - Response and Documentation", "description" => "<i><small><strong>ISO15189:2012 Clause 4.9; 4.10, 4.13; 5.3.1.5<br />Note:</strong> All equipment malfunctions must be investigated and documented as per the non-conforming procedure. In the event that the user cannot resolve the problem, a repair order must be initiated.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipRepair = Note::create(array("name" => "Equipment Repair Monitoring and Documentation", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.1.5; 5.6<br />Note:</strong> After a repair all levels of QC must or other performance checks must be processed to verify that the equipment is in proper working condition. Copies of the QC or performance checks results should be attached to the repair records as evidence.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipFailure = Note::create(array("name" => "Equipment Failure - Contingency Plan", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4 (n); 5.3.1<br />Note:</strong> Interruption to services is considered when a laboratory cannot release results to their  users. Testing services should not be subject to interruption due to equipment malfunctions. Contingency plans must be in place, in the event of equipment failure, for the completion of testing. In the event of a testing disruption, planning may include the use of a back-up instrument, the use of a different testing method, the referral of samples to another laboratory.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_manOpManual = Note::create(array("name" => "Manufacturer’s Operator Manual", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.3<br />Note:</strong> Operator manuals must be readily available for reference by testing staff and must be document controlled.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labTests = Note::create(array("name" => "Laboratory Testing Services", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(a);(n); 4.1.2.1(i);<br />Note:</strong> Interruption to services is considered when a laboratory cannot release results to their users. Testing services should not b e subject to interruption due to equipment malfunctions. Contingency plans must be in place, in the event of equipment failure, for the completion of testing. In the event of a testing disruption, planning may include the use of a back-up instrument, the use of a different testing method, the referral of samples to another laboratory</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 6
        $note_internalAudits = Note::create(array("name" => "Internal Audits", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 4.14.5<br />Note:</strong> The cycle for internal auditing should normally be completed  in one year. The laboratory must conduct internal audits at planned intervals to determine whether all activities in the quality management system, including pre-examination, examination, and post-examination.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_audRec = Note::create(array("name" => "Audit Recommendations", "description" => "<i><small><strong>ISO15189:2012 Clause 4.10; 4.13; 4.14.5:<br />Note:</strong> For actions that are not implemented as per the due dates there should be a motivation and an approval of extension.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_riskManage = Note::create(array("name" => "Risk Management", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 4.14.6</strong><br />The Laboratory shall assess all steps in for all its processes (pre-analytical, analytical and post analytical) for areas of potential pitfalls e.g. pre-analytical step of sample collection, potential pitfalls could be; wrong sample collected, sample collected in wrong container, sam ple collected at wrong time. Post analytical could be; result sent to wrong patient, results sent outside of TAT. The Lab must assess all steps, list potential pitfalls a nd document action taken to prevent these from occurring. <strong>Note:</strong><br /> Risks should be graded and acted upon as per their grading.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 7
        $note_invBudgetSys = Note::create(array("name" => "Inventory and Budgeting System", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.2.1(i); 5.3.2.1; 5.3.2.4<br />Note:</strong> The laboratory must have a systematic way of determining its supply and testing needs through inventory control and budgeting  systems that take into consideration past patterns, present trends and future plans.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_suppSpec = Note::create(array("name" => "Supplier Specification", "description" => "<i><small><strong>ISO15189:2012 Clause 4.6<br />Note:</strong> Specification could be in the form of catalogue number; item number, manufacturer name etc .</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_suppPerfRev = Note::create(array("name" => "Service Supplier Performance Review", "description" => "<i><small><strong>ISO15189:2012 Clause 4.6<br />Note:</strong> All suppliers of services used by the laboratory must be reviewed and monitored for  their performance.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_invCont = Note::create(array("name" => "Inventory Control", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.3.2.7; 5.3.2.4<br />Note:</strong> All incoming orders should be inspected for condition and completeness of the original requests, receipted and documented appropr iately; the date received in the laboratory and the expiry date for the product should be clearly indicated.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_budgetPro = Note::create(array("name" => "Budgetary Projections", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(a)<br />Note:</strong> Budgetary projections will ensure that there are no disruptions to services provided</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_manRevSuppReq = Note::create(array("name" => "Management Review of Supplier Requests", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2.3; 5.3.2.7<br />Note:</strong> Due to the fact that labs have different purchasing approval systems, there should be a system in place that the lab reviews final approval of their original request.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labInvSys = Note::create(array("name" => "Laboratory Inventory System", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2<br />Note:</strong> The laboratory inventory system should reliably inform staff of the minimum amount of stock to be kept in order to avoid inte rruption of service due to stock-outs and the maximum amount to be kept by the laboratory to prevent expiry of reagents.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_stoArea = Note::create(array("name" => "Storage Area", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2.2<br />Note:</strong> Storage of supplies and consumables must be as per the manufacturer’s specifications.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_invOrg = Note::create(array("name" => "Inventory Organization and Wastage Minimization", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2.2 and USAID Deliver Project, Logistics Handbook, Task Order 1<br />Note:</strong> To minimize wastage from product expiry, inventory should be organized in line with the First-Expiry-First-Out (FEFO) principle. Place products that will expire first in front of products with a later expiry date and issue stock accordingly to ensure products in use are not past  their expiry date. Remember that the order in which products are received is not necessarily the order in which they will expire.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_disExPro = Note::create(array("name" => "Disposal of Expired Products", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2.7<br />Note:</strong> Expired products should be disposed of properly and records maintained. If safe disposal is not available at the laboratory , the manufacturer/supplier should take back the expired stock at the time of their next delivery.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_proEx = Note::create(array("name" => "Product Expiration", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2.3<br />Note:</strong> All reagents and test kits in use, as well as those in stock, should be within the manufacturer-assigned expiry dates. If and when expired stock is entered into use, there must be evidence of stability studies and enhanced control (increased frequency of QC) of the stock. Expired control and calibrators must not be used.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labTestServ = Note::create(array("name" => "Laboratory Testing Services", "description" => "<i><small><strong>ISO15189:2012 Clause 4.1.1.4(a);(n); 4.1.2.1(i); 5.5<br />Note:</strong> Interruption to services is considered when a laboratory cannot release results to their users. Testing services should not b e subject to interruption due to stock-outs. Laboratories should pursue all options for borrowing stock from another laboratory or  referring samples to another testing facility while the stock-out is being addressed.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 8
        $note_info4pat = Note::create(array("name" => "Information for patients and users", "description" => "<i><small><strong>ISO15189:2012 Clause 5.4.1<br />Note:</strong> The laboratory shall have documented procedures and information for pre-examination activities to ensure the validity of the results of examinations and must make these available to those who collect samples.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_adeqInfo = Note::create(array("name" => "Adequate Information", "description" => "<i><small><strong>ISO15189:2012  Clause 4.4; 5.4.3<br />Note:</strong> Each request accepted by the laboratory for examination(s) shall be considered an agreement. The request may be in the form o f a hard copy or electronically.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_adeqSamp = Note::create(array("name" => "Adequate Sample Procedures", "description" => "<i><small><strong>ISO15189:2012 Clause 4.4; 5.4.6<br />Note:</strong> The review of service agreements occurs on sample reception. All portions of the primary sample must be unequivocally traceable to the original primary sample.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_preExHand = Note::create(array("name" => "Pre-examination handling", "description" => "<i><small><strong>ISO15189:2012 Clause 5.4.7<br />Note:</strong> Specimens should be stored under the appropriate conditions to maintain the stability of the specimen.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_sampTrans = Note::create(array("name" => "Sample transportation", "description" => "<i><small><strong>ISO15189:2012 Clause 5.4.4.3; 5.4.5<br />Note:</strong> All samples should be transported to the laboratory in a manner that is safe to the patients, the public and the environment. The laboratory must ensure that the samples were received within a temperature interval specified for sample collection.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_evalRefLabs = Note::create(array("name" => "Evaluation of Referral Laboratories", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 4.5<br />Note:</strong> The laboratory must have system in place to ensure that the referral laboratories are competent to perform the services requi red. Evaluations in the form of checking their accreditation status, using a questionnaire, performing audits, use of blinded samples etc.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docExProc = Note::create(array("name" => "Documentation of Examination Procedures", "description" => "<i><small><strong>ISO15189:2012 Clause 5.5.3<br />Note:</strong> examination procedures are for the laboratory staff to use therefore it should be in the language that is commonly understood by the staff; the lab may translate the documents into other languages which must be document controlled.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_reAccTest = Note::create(array("name" => "Reagent Acceptance Testing", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.2.3<br />Note:</strong> This may be accomplished by a comparison study or examining quality control samples and verifying that results are acceptable .</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qualityCon = Note::create(array("name" => "Quality Control", "description" => "<i><small><strong>ISO15189:2012 Clause 5.6.2<br />Note:</strong> QC must be verified as being within the acceptable limits before releasing results.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qualityConData = Note::create(array("name" => "Quality Control Data", "description" => "<i><small><strong>ISO15189:2012 Clause 5.6.2.3<br />Note:</strong> The lab must document and implement a system it would use to evaluate patient results since the last successful quality control; the evaluation could be done by re-examining selected samples of various batches, re-examining samples as per the stability of the Quality Control etc.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_compaExRes = Note::create(array("name" => "Comparability of Examination Results", "description" => "<i><small><strong>ISO15189:2012 Clause 5.6.4<br />Note:</strong> The lab should document and implement a system to ensure there is comparability of results, this could be done by the use of  EQA performance; using blinded samples, parallel testing.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_envConCheck = Note::create(array("name" => "Environmental conditions checked", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.6<br />Note:</strong> The laboratory shall monitor, control and record environmental conditions, as required by relevant specifications or where th ey may influence the quality of the sample, results, and/or the health of staff.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_accRanges = Note::create(array("name" => "Acceptable ranges defined", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.2(c)<br />Note:</strong> Acceptable ranges should take into consideration manufacturers’ recommendations and requirements.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_interLab = Note::create(array("name" => "Participation in Inter-laboratory Comparison", "description" => "<i><small><strong>ISO15189:2012 Clause 5.6.3<br />Note:</strong> The laboratory should handle, analyze, review and report results for proficiency testing in a manner similar to regular patient testing. Investigation and correction of problems identified by unacceptable proficiency testing should be documented. Acceptable results showing bias o r trends suggest that a problem should also be investigated.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 9
        $note_testResRep = Note::create(array("name" => "Test Result Reporting System", "description" => "<i><small><strong>ISO15189:2012 Clause5.8.1<br />Note:</strong> Results must be written in ink and written clearly with no mistakes in transcription. The persons performing the test must indicate verification of the results. There must be a signature or identification of the person authorizing the release of the report.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_testPersonnel = Note::create(array("name" => "Testing Personnel", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13 ; 5.5.1.1; 5.8.1<br />Note:</strong> The person who performed the procedure must be identified on the report (hard copy or electronic) purposes of traceability</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_repCont = Note::create(array("name" => "Report content", "description" => "<i><small><strong>ISO15189:2012 Clause 5.8.2; 5.8.3; 5.9.3<br />Note:</strong> When the reporting system cannot capture amendments, changes or alterations, a record of such shall be kept.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_analyticSys = Note::create(array("name" => "Analytic System/Method Tracing", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13(g)<br />Note:</strong> There must be traceability of specimen results to a specific analytical system or method. Proficiency testing specimens would  also fall under specimen results.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_arcDataLab = Note::create(array("name" => "Archived Data Labeling", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.10.3<br />Note:</strong> All patient data, paper, tapes, disks must be retained as per the lab’s retention policy and should be stored in a safe and access controlled environment.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_authResp = Note::create(array("name" => "Authorities Responsibilities", "description" => "<i><small><strong>ISO15189:2012 Clause 5.9; 5.10.2; 5.10.3<br />Note:</strong> information systems includes the management of data and information contained in both computer and non -computerized systems. Some of the requirements may be more applicable to computer systems than to non-computerized systems. Computerized systems can include those integral to the functioning of laboratory equipment and standalone systems using generic software, such as word processing, spreadsheet and database app lications that generate, collate, report and archive patient information and reports.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_infoManSys = Note::create(array("name" => "Information Management System", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.1<br />Note:</strong> The laboratory must have a documented procedure and records for the selection, purchasing and management of equipment .</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_testRes = Note::create(array("name" => "Test Results", "description" => "<i><small><strong>ISO15189:2012 Clause 5.1; 5.8; 5.10.3; 5.9.1<br />Note:</strong> There must be a signature or identification of the person authorizing the release of the report.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_lisVer = Note::create(array("name" => "Verification of LIS", "description" => "<i><small><strong>ISO15189:2012 Clause 4.13; 5.10.3<br />Note:</strong> The lab must perform verification of system after upgrades and to ensure previously stored patient results have not  been affected.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_lisMan = Note::create(array("name" => "LIS maintenance", "description" => "<i><small><strong>ISO15189:2012 Clause 5.10.3<br />Note:</strong> If the LIS is maintained offsite, records of maintenance must be readily available .The lab should in clude the LIS as part of their internal audit.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 10
        $note_nonConf = Note::create(array("name" => "Nonconforming activities", "description" => "<i><small><strong>ISO15189:2012  Clause 4.9<br />Note:</strong> nonconformities should be identified and managed in any aspect of the quality management system, including pre -examination, examination or post-examination processes. Nonconforming examinations or activities occur in many different areas and can be identified in many different ways, includin g clinician complaints, internal quality control indications, and instrument calibrations, checking of consumable materials, inter-laboratory comparisons, staff comments, reporting and certificate checking, laboratory management reviews, and internal and external audits.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_rootCause = Note::create(array("name" => "Root Cause Analysis", "description" => "<i><small><strong>ISO15189:2012 Clause 4.10(b)<br />Note:</strong> Root cause analysis is a process of identifying and removing the underlying factor of the  non-conformance.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_corrActPerf = Note::create(array("name" => "Corrective Action Performed", "description" => "<i><small><strong>ISO15189:2012 Clause 4.10; 4.13; 4.14.5<br />Note:</strong> Documenting corrective action allows the lab to review its effectiveness and to perform trend analysis for continual improvement .</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_corrActMon = Note::create(array("name" => "Corrective Action Monitoring", "description" => "<i><small><strong>ISO15189:2012 Clause 4.10(f)<br />Note:</strong> Implemented corrective action does not imply effectiveness; therefore the lab has to monitor to  ensure that the NC has not recurred.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_prevActions = Note::create(array("name" => "Preventive Actions", "description" => "<i><small><strong>ISO15189:2012 Clause 4.11; 4.12;<br />Note:</strong> Preventive  action  should  be  an  ongoing  process  involving  analysis  of  laboratory  data,  including  trend  and  risk  analyses  and  e xternal  quality  assessment (proficiency testing).</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 11
        $note_graphTools = Note::create(array("name" => "Graphical tools", "description" => "<i><small><strong>ISO15189:2012 Clause 4.12; 4.13; 4.14<br />Note:</strong> Use of graphical displays of quality data communicates more effectively than tables of numbers. Examples of graphical tools c ommonly used for this purpose include LJ charts; Pareto charts, cause-and-effect diagrams, frequency histograms, trend graphs, and flow charts.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_quaManSys = Note::create(array("name" => "Quality Management System", "description" => "<i><small><strong>ISO15189:2012 Clause 4.12; 4.15<br />Note:</strong> The lab should use its management review activities to continually improve its quality management system by comparing its actual performance to its intentions stated in the quality policy and objectives.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_commSysLab = Note::create(array("name" => "Communication System in Laboratory", "description" => "<i><small><strong>ISO15189:2012 Clause 4.15.2 (o)<br />Note:</strong> The laboratory staff should give input for management meetings.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qIndicators = Note::create(array("name" => "Quality indicators", "description" => "<i><small><strong>ISO15189:2012 Clause4.12; 4.14.7<br />Note:</strong> The lab should select QI in line with meeting its objectives from pre-analytic, analytic and post-analytic phases critical to patient outcomes.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_outOfRev = Note::create(array("name" => "Outcomes of Reviews", "description" => "<i><small><strong>ISO15189:2012 Clause 4.14.7; 4.15.2(f)<br />Note:</strong> The lab should review the QI to ensure its continued appropriateness.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_actCheckMon = Note::create(array("name" => "Actions Checked and Monitored", "description" => "<i><small><strong>ISO15189:2012 Clause 4.14.7<br />Note:</strong> the lab should create an action plan to monitor the QI stating the  objectives, methodology, interpretation, limits, action plan and duration of measurement for each QI.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 12
        $note_sizeOfLab = Note::create(array("name" => "Size of the laboratory adequate", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.1<br />Note:</strong> Documentation could be in the form of a floor plan, results from internal audits, etc.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_careNTesting = Note::create(array("name" => "Patient care and testing areas", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.1<br />Note:</strong> Client service areas (i.e. waiting room, phlebotomy room) should be distinctly separate from the testing areas of the laborat ory. Client access should not compromise “clean” areas of the laboratory. For biosafety reasons, microbiology and TB testing should be segregated in a separate room(s) from the general laboratory testing.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_workStaMain = Note::create(array("name" => "Individual workstation maintained", "description" => "<i><small><strong>ISO15190 Clause 6.3.5</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_phyWorkEnv = Note::create(array("name" => "Physical work environment appropriate", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2<br />Note:</strong> The laboratory space should be sufficient to ensure the quality of work, safety of personnel and the ability of staff to carry out their tasks without compromising the quality of the examinations. The laboratory should be clean and well organized, free of clutter, well ventilated, adequat ely lit and within acceptable temperature ranges.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labSecured = Note::create(array("name" => "Laboratory properly secured from unauthorized access", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.2<br />Note:</strong> Access control should take into consideration safety, confidentiality, and quality.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labDedColdRoom = Note::create(array("name" => "Laboratory-dedicated cold and room", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2; 5.2.4<br />Note:</strong> there should be effective separation to prevent contamination.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_leakageSpills = Note::create(array("name" => "Work area clean and free of leakage & spills", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.6<br />Note:</strong> The work area should be cleaned regularly. An appropriate disinfectant should be used. At a minimum, all bench tops and worki ng surfaces should be disinfected at the beginning and end of every shift. All spills should be contained immediately and the  work surfaces disinfected.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_certBiosafetyCab = Note::create(array("name" => "Certified and appropriate Biosafety cabinet", "description" => "<i><small><strong>ISO 15189:2012 Clause 5.2.1.; 5.2.2<br />Note:</strong> A biosafety cabinet should be used to prevent aerosol exposure to contagious specimens or organisms. For proper functioning a nd full protection, biosafety cabinets require periodic maintenance and should be serviced accordingly. Biosafety cabinet should be recertified according to national protocol or manufacturer requirements.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labSafetyManual = Note::create(array("name" => "Laboratory safety manual", "description" => "<i><small><strong>ISO15190 Clause 7.4<br />Note:</strong> A safety manual should be readily available to all employees. The manual should be specific to the laboratory's needs; it must  be document controlled.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_suffWasteDisposal = Note::create(array("name" => "Sufficient waste disposal available", "description" => "<i><small><strong>ISO15190 Clause 22<br />Note:</strong> Waste should be separated according to biohazard risk, with infectious and non-infectious waste disposed of in separate containers. Infectious waste should be discarded into containers that do not leak and are clearly marked with a biohazard symbol. Sharp instruments and needles shou ld be discarded in puncture resistant containers. Both infectious waste and sharps containers should be autoclaved before being discarded to decontaminate potentia lly infectious material. To prevent injury from exposed waste, infectious waste should be incinerated, burnt in a pit or  buried.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_hazardousChem = Note::create(array("name" => "Hazardous chemicals / materials properly handled", "description" => "<i><small><strong>ISO15190 Clause 17.1; 17.3<br />Note:</strong> All hazardous chemicals must be labelled with the chemical’s name and with hazard markings. Flammable chemicals must be stored out of sunlight and below their flashpoint, preferably in a steel cabinet in a well-ventilated area. Flammable and corrosive agents should be separated from one another. Distinct care should always be taken when handling hazardous chemicals.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_sharpsDisposed = Note::create(array("name" => "'Sharps' handled and disposed of properly", "description" => "<i><small><strong>ISO15189:2012 Clause 5.2.3<br />Note:</strong> All syringes, needles, lancets or other bloodletting devices capable of transmitting infection must be used only once and dis carded in puncture resistant containers that are not overfilled. Sharps containers should be clearly marked to warn handlers of th e potential hazard and should be located in areas where sharps are commonly used.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_fireSafety = Note::create(array("name" => "Fire safety included in overall safety program", "description" => "<i><small><strong>ISO15190 Clause 9.3; 9.7<br />Note:</strong> Electrical cords and plugs, power-strips and receptacles should be maintained in good condition and utilized appropriately. Overloading should be  avoided and cords should be kept out of walkway areas. An approved fire extinguisher should be easily accessible within the laboratory an d be routinely inspected and documented for readiness. Fire extinguishers should be kept in their assigned place and no t hidden or blocked; the pin and seal should be intact, nozzles should be free of blockage, pressure gauges should show adequate pressure, and there should be no visible signs of damage. A fire alarm should be install ed in the laboratory and tested regularly for readiness; all staff should participate in periodic fire drills.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_inspAudReg = Note::create(array("name" => "Safety inspections or audits conducted regularly", "description" => "<i><small><strong>ISO15190 Clause 7.3.1 and 7.3.2<br />Note:</strong> The safety programme shall be audited and reviewed at least annually (by appropriately trained personnel.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_stdSafetyEqui = Note::create(array("name" => "Standard safety equipment available", "description" => "<i><small><strong>ISO15190 Clause 5.1<br />Note:</strong> It is the responsibility of laboratory management to ensure that the laboratory is equipped with standard safety equipment. T he list above is a partial list of necessary items. Biosafety cabinets should be in place and in use as required. All centrifuges should have covers. Hand-washing stations should be designated and equipped and eyewash stations (or an acceptable alternative method of eye cleansing) should be available and operable. Spill  kits and first aid kits should be kept in a designated place and checked regularly for readiness.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_personalProEqui = Note::create(array("name" => "Personal protective equipment", "description" => "<i><small><strong>ISO15190 Clause 12<br />Note:</strong> Management is responsible for providing appropriate personal protective equipment (gloves, lab coats, eye protection, etc.) in useable condition. Laboratory staff must utilize PPE at all times while in the laboratory. Protective clothing should not be  worn outside the laboratory. Gloves should be replaced immediately when torn or contaminated and not washed for reuse.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_vaccPrevMeasures = Note::create(array("name" => "Appropriate vaccination/preventive measures", "description" => "<i><small><strong>ISO15190 Clause 11.3<br />Note:</strong> Laboratory staff should be offered appropriate vaccinations—particularly Hepatitis B. Staff may decline to receive the vaccination, but they must then sign a declination form to be held in the staff member’s personnel file.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_postExProphy = Note::create(array("name" => "Post-exposure prophylaxis policies and procedures", "description" => "<i><small><strong>ISO15190 Clause 9<br />Note:</strong> The laboratory must have a procedure for follow-up of possible and known percutaneous, mucus membrane or abraded skin exposure to HIV, HBV or HCV. The procedure should include clinical and serological evaluation and appropriate prophylaxis.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_occInjuries = Note::create(array("name" => "Occupational injuries documented", "description" => "<i><small><strong>ISO15189:2012 Clause 5.3.1.6; 5.3.2.6;  ISO15190 Clause 9<br />Note:</strong> All occupational injuries or illnesses should be thoroughly investigated and documented in the safety log or occurrence log,  depending on the laboratory. Corrective actions taken by the laboratory in response to an accident or injury must also be documented.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_workersTraBiosafety = Note::create(array("name" => "Drivers/couriers and cleaners trained in Biosafety ", "description" => "<i><small><strong>ISO15189:2012 Clause 5.1.5(d); ISO15190 Clause 5.10<br />Note:</strong> all staff must be trained in prevention or control of the effects of adverse incidents.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_trainedSafetyOfficer = Note::create(array("name" => "Trained safety officer for safety program", "description" => "<i><small><strong>ISO15190 Clause 7.10<br />Note:</strong> A safety officer should be appointed, implement and monitor the safety program, coordinate safety training, and handle all safety issues. This officer should receive safety training.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $this->command->info('Notes table seeded');

        /* Sections */
        $sec_mainPage = Section::create(array("name" => "Main Page", "label" => "1.0 INTRODUCTION", "description" => "", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_part1 = Section::create(array("name" => "Part I", "label" => "Part I", "description" => "", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_slmtaInfo = Section::create(array("name" => "SLMTA Info", "label" => "SLMTA Information", "description" => "", "total_points" => "0", "order" => $sec_mainPage->id, "user_id" => "1"));
        $sec_labProfile = Section::create(array("name" => "Lab Profile", "label" => "Laboratory Profile", "description" => "", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_labInfo = Section::create(array("name" => "Lab Info", "label" => "Lab Information", "description" => "", "total_points" => "0", "order" => $sec_slmtaInfo->id, "user_id" => "1"));
        $sec_staffSummary = Section::create(array("name" => "Staffing Summary", "label" => "Laboratory Staffing Summary", "description" => "", "total_points" => "0", "order" => $sec_labInfo->id, "user_id" => "1"));
        $sec_part2 = Section::create(array("name" => "Part II", "label" => "Part II", "description" => "", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_prelude = Section::create(array("name" => "Prelude", "label" => "PART II: LABORATORY AUDITS", "description" => "", "total_points" => "0", "order" => $sec_staffSummary->id, "user_id" => "1"));
        $sec_sec1 = Section::create(array("name" => "Section 1", "label" => "1.0 DOCUMENTS AND RECORDS", "description" => "", "total_points" => "28", "order" => $sec_prelude->id, "user_id" => "1"));
        $sec_sec2 = Section::create(array("name" => "Section 2", "label" => "2.0 MANAGEMENT REVIEWS AND MANAGEMENT RESPONSIBILITIES", "description" => "", "total_points" => "14", "order" => $sec_sec1->id, "user_id" => "1"));
        $sec_sec3 = Section::create(array("name" => "Section 3", "label" => "3.0 ORGANIZATION AND PERSONNEL", "description" => "", "total_points" => "22", "order" => $sec_sec2->id, "user_id" => "1"));
        $sec_sec4 = Section::create(array("name" => "Section 4", "label" => "4.0 CLIENT MANAGEMENT AND CUSTOMER SERVICE", "description" => "", "total_points" => "10", "order" => $sec_sec3->id, "user_id" => "1"));
        $sec_sec5 = Section::create(array("name" => "Section 5", "label" => "5.0 EQUIPMENT", "description" => "", "total_points" => "35", "order" => $sec_sec4->id, "user_id" => "1"));
        $sec_sec6 = Section::create(array("name" => "Section 6", "label" => "6.0 EVALUATIONS AND AUDITS", "description" => "", "total_points" => "12", "order" => $sec_sec5->id, "user_id" => "1"));
        $sec_sec7 = Section::create(array("name" => "Section 7", "label" => "7.0 PURCHASING AND INVENTORY CONTROL", "description" => "", "total_points" => "26", "order" => $sec_sec6->id, "user_id" => "1"));
        $sec_sec8 = Section::create(array("name" => "Section 8", "label" => "8.0 PROCESS CONTROL", "description" => "", "total_points" => "32", "order" => $sec_sec7->id, "user_id" => "1"));
        $sec_sec9 = Section::create(array("name" => "Section 9", "label" => "9.0 INFORMATION MANAGEMENT", "description" => "", "total_points" => "21", "order" => $sec_sec8->id, "user_id" => "1"));
        $sec_sec10 = Section::create(array("name" => "Section 10", "label" => "10.0 IDENTIFICATION OF NON CONFORMITIES, CORRECTIVE AND PREVENTIVE ACTION", "description" => "", "total_points" => "19", "order" => $sec_sec9->id, "user_id" => "1"));
        $sec_sec11 = Section::create(array("name" => "Section 11", "label" => "11.0 OCCURRENCE MANAGEMENT AND PROCESS IMPROVEMENT", "description" => "", "total_points" => "12", "order" => $sec_sec10->id, "user_id" => "1"));
        $sec_sec12 = Section::create(array("name" => "Section 12", "label" => "12.0 FACILITIES & BIOSAFETY", "description" => "", "total_points" => "43", "order" => $sec_sec11->id, "user_id" => "1"));
        $sec_part3 = Section::create(array("name" => "Part III", "label" => "Part III", "description" => "", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_summary = Section::create(array("name" => "Summary", "label" => "PART III: SUMMARY OF AUDIT FINDINGS", "description" => "", "total_points" => "0", "order" => $sec_sec12->id, "user_id" => "1"));
        $sec_actionP = Section::create(array("name" => "Action Plan", "label" => "ACTION PLAN (IF APPLICABLE)", "description" => "", "total_points" => "0", "order" => $sec_summary->id, "user_id" => "1"));
        $sec_sliptaCert = Section::create(array("name" => "SLIPTA Certification", "label" => "Criteria for SLIPTA 5 star certification and accreditation of international standards)", "description" => "", "total_points" => "0", "order" => $sec_actionP->id, "user_id" => "1"));
        $this->command->info('Sections table seeded');
        /* audit-type-sections */
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_mainPage->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_part1->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_slmtaInfo->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_labProfile->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_labInfo->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_staffSummary->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_part2->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_prelude->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec1->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec2->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec3->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec4->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec5->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec6->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec7->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec8->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec9->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec10->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec11->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sec12->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_part3->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_summary->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_actionP->id));
        DB::table('audit_type_sections')->insert(
            array("audit_type_id" => "1", "section_id" => $sec_sliptaCert->id));
        $this->command->info('Audit-type-sections table seeded');
        /* Section parent-child */
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_slmtaInfo->id, "parent_id" => $sec_part1->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_labProfile->id, "parent_id" => $sec_part1->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_labInfo->id, "parent_id" => $sec_labProfile->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_staffSummary->id, "parent_id" => $sec_labProfile->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_prelude->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec1->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec2->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec3->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec4->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec5->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec6->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec7->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec8->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec9->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec10->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec11->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sec12->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_summary->id, "parent_id" => $sec_part3->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_actionP->id, "parent_id" => $sec_part3->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_sliptaCert->id, "parent_id" => $sec_part3->id));
        $this->command->info('Section parent-child table seeded');

         /* Section-Notes */
        DB::table('section_notes')->insert(
            array("section_id" => $sec_mainPage->id, "note_id" => $note_intro->id));
        DB::table('section_notes')->insert(
            array("section_id" => $sec_prelude->id, "note_id" => $note_prelude->id));
        DB::table('section_notes')->insert(
            array("section_id" => $sec_sliptaCert->id, "note_id" => $note_certification->id));
        $this->command->info('Section-Note table seeded');

        /* Questions */
        //  Section 1 - Documents and Records
        $question_legalEntity = Question::create(array("section_id" => $sec_sec1->id, "name" => "Legal Entity", "title" => "1.1 Legal Entity", "description" => "Does the laboratory have documentation stating its legal identity?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labQManual = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Quality Manual", "title" => "1.2 Laboratory Quality Manual", "description" => "Is there a current laboratory quality manual, composed of the quality management system’s policies and procedures, and has the manual content been communicated to and understood and implemented by all staff?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_labQPolicy = Question::create(array("section_id" => $sec_sec1->id, "name" => "Quality policy statement", "title" => "", "description" => "a) Quality policy statement that includes scope of service, standard of service, measurable objectives of the quality management system, and management commitment to compliance.", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labQMS = Question::create(array("section_id" => $sec_sec1->id, "name" => "Lab QMS Structure", "title" => "", "description" => "b) Documented policies for the quality management system that meet the requirements of ISO15189:2012 <strong>(Refer to Question 1.5 of this checklist for list of policies required)</strong>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labQStructure = Question::create(array("section_id" => $sec_sec1->id, "name" => "Structure defined ", "title" => "", "description" => "c) Description of the quality management system and the structure of its documentation", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labSProcedures = Question::create(array("section_id" =>$sec_sec1->id, "name" => "Lab Supporting Procedures", "title" => "", "description" => "d) Reference to supporting procedures (SOPs), including managerial and technical procedures", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labRoles = Question::create(array("section_id" => $sec_sec1->id, "name" => "Description of Lab Roles and Responsibilities", "title" => "", "description" => "e) Description of the roles and responsibilities of the laboratory director, or laboratory manager, quality manager, and other key personnel (laboratory to define its key personnel) responsible for ensuring compliance", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labDocManReview = Question::create(array("section_id" => $sec_sec1->id, "name" => "Documentation of Annual Review", "title" => "", "description" => "f) Records of review and approval of the quality manual by authorized personnel", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labPers = Question::create(array("section_id" => $sec_sec1->id, "name" => "Documentation of Annual Review", "title" => "", "description" => "g) Records to show that the quality manual was communicated to and understood by the lab personnel", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_docInfoCon = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document and Information Control System", "title" => "1.3 Document and Information Control System", "description" => "Does the laboratory have a system in place to control all documents and information (internal and external sources)?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_docRecords = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document and Records", "title" => "1.4 Document and Records", "description" => "Are documents and records properly maintained, easily accessible and fully detailed in an up-to-date Master List?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_poSops = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Policies and Standard Operating Procedures", "title" => "1.5 Laboratory Policies and Standard Operating Procedures", "description" => "Are policies and standard operating procedures (SOPs) for laboratory functions current, available and approved by authorized personnel?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_sopsEthCon = Question::create(array("section_id" => $sec_sec1->id, "name" => "Ethical Conduct", "title" => "Ethical Conduct", "description" => "How the laboratory will: 1) minimize activities that would diminish confidence in the laboratory's competence, impartiality, and judgment; 2) perform work within relevant legal requirements; 3) ensure confidentiality; 4) handle human samples, tissues or their remains as per regulations; 5) identify and avoid potential conflicts of interest and commercial, financial, political or other pressures that may affect the quality and integrity of operations?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_docRecControl = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document Record Control", "title" => "Document Control", "description" => "How the laboratory will: 1) control all internal and external documents; 2) create documents; 3) identify documents; 4) review documents; 5) approve documents; 6) capture current versions and their distribution by means of a list; 7) handle amendments; 8) identify changes; 9) handle obsolete documents; 10) retain documents; 11) prevent the unintended use of any obsolete document; 12) ensure safe disposal of documents?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_recControl = Question::create(array("section_id" => $sec_sec1->id, "name" => "Control of Records", "title" => "Control of Records", "description" => "How the laboratory will: 1) identify; 2) collect; 3) index; 4) access; 5) store; 6) maintain; 7) amends; 8) dispose of safely; 9) define the retention period for the identified records?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_communication = Question::create(array("section_id" => $sec_sec1->id, "name" => "Communication", "title" => "Communication (internal and external)", "description" => "How the laboratory will: 1) ensure effective communication with staff and users of the laboratory; 2) handle staff suggestions for improvement; 3) communicate with stakeholders on the effectiveness of the quality management system across all processes; 4) capture records of all communications; 5) retain and maintain all records of communication, requests, inquiries, verbal discussions and requests for additional examinations, meeting agendas, and meeting minutes)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_servAgr = Question::create(array("section_id" => $sec_sec1->id, "name" => "Service Agreements", "title" => "Service Agreements", "description" => "How the laboratory will: 1) establish service agreements; 2) review service agreements; 3) handle walk in patients (if applicable); 4) inform customers and users of any changes that affect the results of the requisition stated on the service agreement; 5) communicate to the requester of any work that has been referred; 6) retain records of communication?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_referralExam = Question::create(array("section_id" => $sec_sec1->id, "name" => "Examination by Referral Laboratories", "title" => "Examination by Referral Laboratories and Consultants", "description" => "How the laboratory will: 1) select referral laboratories and consultants who provide opinions as well as interpretations; 2) evaluate and monitor the performance of referral laboratories and consultants who provide opinions as well as interpretations; 3) maintain a list of approved referral laboratories and consultants; 4) maintain a records of referred samples; 5) tracking of referred samples and their results; 6) report results from referral labs; 7) package and transport referred samples; 8) record communication of results from referral laboratories and consultants?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_extSerSupp = Question::create(array("section_id" => $sec_sec1->id, "name" => "External Services and Suppliers", "title" => "External Services and Suppliers", "description" => "How the laboratory will: 1) select external purchases and services; 2) establish its selection criteria, including acceptance and rejection criteria; 3) approve and maintain its approved suppliers list; 4) define the requirements of its purchase supplies and services; 5) review and monitor the performance of its approved suppliers; 6) establish frequency of reviews ?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_purInvCon = Question::create(array("section_id" => $sec_sec1->id, "name" => "Purchasing and Inventory Control", "title" => "Purchasing and Inventory Control", "description" => "How the laboratory will: 1) request, order and receive supplies; 2) establish acceptance/rejection criteria for purchased items; 3) store purchased supplies; 4) control their inventory; 5) monitor and handle expired consumables?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_advisory = Question::create(array("section_id" => $sec_sec1->id, "name" => "Advisory Services", "title" => "Advisory Services", "description" => "How the laboratory will: 1) request, order and receive supplies; 2) establish acceptance/rejection criteria for purchased items; 3) store purchased supplies; 4) control their inventory; 5) monitor and handle expired consumables?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_compFeedback = Question::create(array("section_id" => $sec_sec1->id, "name" => "Resolution of Complaints and Feedback", "title" => "Resolution of Complaints and Feedback", "description" => "How the laboratory will: 1) manage complaints received from clinicians, patients, laboratory staff or other parties; 2) collect, receive and handle feedback received from clinicians, patients, laboratory staff or other parties; 3) keep records of all complaints, the investigations and actions taken, 4) determine the timeframe for closure and feedback to the complainant; 5) monitor effectiveness of corrective and preventative actions taken on complaints and feedback?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_nonConformities = Question::create(array("section_id" => $sec_sec1->id, "name" => "Identification and Control of Nonconformities", "title" => "Identification and Control of Nonconformities", "description" => "How the laboratory will: 1) identify types of nonconformities in any aspect of the quality management system from pre, analytic and post analytic; 2) record NCs (how and where); 3) assign who is responsible for resolving the NC; 4) determine time frame for resolving NCs; 5) halt examinations (by an authorized person); 6) ensure  the recall of released results of nonconforming or potentially nonconforming examinations; 7) release results after corrective action has been taken?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_corrAction = Question::create(array("section_id" => $sec_sec1->id, "name" => "Corrective Action", "title" => "Corrective Action", "description" => "How the laboratory will: 1) determine the root cause; 2) evaluate the need for CA to ensure that NCs do not recur; 3) assign the person responsible for the CA; 4) determine and implement CA(including person responsible and timeframe); 4) record CA taken; 4) monitor and review the effectiveness of the CA taken?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_prevAction = Question::create(array("section_id" => $sec_sec1->id, "name" => "Preventive Action", "title" => "Preventive Action", "description" => "How the laboratory will: 1) review laboratory data and information to determine potential nonconformities; 2) determine the root cause(s) of potential non conformities; 3) evaluate the need for preventive action; 4) record the PA; 5) determine and implement PA (including person responsible and timeframe); 6) monitor and review the effectiveness of implementation of PA?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_contImpro = Question::create(array("section_id" => $sec_sec1->id, "name" => "Continual Improvement", "title" => "Continual Improvement", "description" => "How the laboratory will: 1) identify improvement activities within the Quality Management System; 2) develop improvement plans; 3) record improvement plans; 4) implement action plans; 5) communicate improvement plans and related goals to staff?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_conRec = Question::create(array("section_id" => $sec_sec1->id, "name" => "Control of Records", "title" => "Control of Records", "description" => "How the laboratory will: 1) identify; 2) collect; 3) index; 4) access; 5) store; 6) maintain; 7) amends; 8) dispose of safely; 9) define the retention period for the identified records?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_inAudits = Question::create(array("section_id" => $sec_sec1->id, "name" => "Internal Audits", "title" => "Internal Audits", "description" => "How the laboratory will: 1) determine an audit schedule; 2) determine the roles and responsibilities for planning and conducting audits; 3) select the auditors; 4) define the types of audits; 4) define the frequency of audits; 5) define the scope of the internal audit; 6) record audit findings (forms and reports); 7) ensure corrective action is taken for all nonconformities identified with in the allocated time frame; 8) closure of Non Conformities identified during audits?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_riskMan = Question::create(array("section_id" => $sec_sec1->id, "name" => "Risk Management", "title" => "Risk Management", "description" => "How the laboratory will: 1) evaluate the impact of potential pitfalls on work processes and examination results that affect patient results? <i><strong>(Refer to Question 6.3 of this checklist)</strong></i>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_manReview = Question::create(array("section_id" => $sec_sec1->id, "name" => "Management Review", "title" => "Management Review", "description" => "How the laboratory will: 1) define frequency of having a management reviews; 2) define the agenda (input); 3) determine the key attendees; 4) record decisions and actions to be taken (output); 5) assign a person responsible and due dates for actions arising; 6) communicate decisions and actions to be taken to the relevant persons including laboratory staff; 7) ensure all actions arising are completed within the defined timeframe? <i><strong>(refer to Question 2.2 of this checklist for the agenda of the meeting)</strong></i>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_persMan = Question::create(array("section_id" => $sec_sec1->id, "name" => "Personnel Management", "title" => "Personnel Management", "description" => "How the laboratory will: 1) define the structure of the organization (organizational plan); 2) manage personnel (personnel policies); 3) maintain personnel records? <i><strong>(refer to Question 3.5 of the checklist for list of personnel records required)</strong></i>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_persTraining = Question::create(array("section_id" => $sec_sec1->id, "name" => "Personnel Training", "title" => "Personnel Training", "description" => "How the laboratory will: 1) perform staff orientation; 2) conduct initial and refresher training; 3) provide a continuous education program; 4) identify required training relevant to job title and responsibilities; 5) keep record of training; 6) evaluate the effectiveness of training?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_competencyAudit = Question::create(array("section_id" => $sec_sec1->id, "name" => "Competency Assessment", "title" => "Competency Assessment", "description" => "How the laboratory will: 1) assess the competence of personnel to perform assigned managerial or technical tasks; 2) assess ongoing competency; 3) establish competency criteria; 4) provide feedback to persons assessed; 5) schedule retraining based on the assessment outcome; 6) keep records of competency assessments and outcomes?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_Auth = Question::create(array("section_id" => $sec_sec1->id, "name" => "Authorization", "title" => "Authorization", "description" => "How the laboratory will: 1) document authorization levels for the different tasks and roles; 2) appoint deputies for the key positions where appropriate?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_revStaffPerf = Question::create(array("section_id" => $sec_sec1->id, "name" => "Review of Staff Performance", "title" => "Review of Staff Performance", "description" => "How the laboratory will: 1) plan and perform staff appraisals; 2) establish frequency of monitoring and review of staff performance outcome; 3) keep records of staff performance; 4) train staff who perform staff appraisals?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_Accomo = Question::create(array("section_id" => $sec_sec1->id, "name" => "Accommodation and Environmental Conditions", "title" => "Accommodation and Environmental Conditions", "description" => "How the laboratory will: 1) evaluate and determine the sufficiency and adequacy of the space allocated for the performance of and scope of work; 2) ensure the laboratory and office facilities are suitable for the tasks to be undertaken; 3) ensure the storage and disposal facilities meet the applicable requirements; 4) ensure staff have space for staff activities (supply of drinking water, storage space for personal and protective equipment and clothing); 5) monitor, control and record any specific environmental and accommodation requirements?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_Equip = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Equipment", "title" => "Laboratory Equipment", "description" => "How the laboratory will: 1) select equipment; 2) purchase equipment; 3) manage equipment; 4) maintain equipment records 3) capture the minimum information on equipment label; 4) manage defective equipment; 5) define the equipment maintenance frequency; 6) record the maintenance ; 7) prevent unauthorized use (access control) of equipment; 8) manage obsolete equipment; 9) manage safe handling, transportation, storage and use to avoid deterioration and contamination, 9) track and verify completion of repairs?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_EquiCalib = Question::create(array("section_id" => $sec_sec1->id, "name" => "Calibration of Equipment", "title" => "Calibration of Equipment", "description" => "How the laboratory will: 1) define frequency of calibration; 2) handle in house calibrations (pipettes, thermometers, timers etc.); 3) record calibration status (use of stickers and calibration certificates); 4) handle failed calibrations?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_preExamPro = Question::create(array("section_id" => $sec_sec1->id, "name" => "Pre-examination Process", "title" => "Pre-examination Process", "description" => "How the laboratory will provide information for patients and users on: 1) primary sample collection and handling; 2) instructions for pre-collection activities; 3) instructions for collection activities; 4) preparation and storage prior to dispatch to the laboratory; 5) sample and volume requirements; 6) Sample transportation; 7) time limits and special handling; 8) acceptance and rejection criteria; 9) confidentiality; 10) complaints procedure?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_valVer = Question::create(array("section_id" => $sec_sec1->id, "name" => "Validation and Verification of examination procedures / Equipment", "title" => "Validation and Verification of examination procedures / Equipment", "description" => "How the laboratory will: 1) select testing procedures; 2) perform equipment validation; 3) perform method validation; 4) perform equipment verification; 5) perform method verification; 6) define validation /verification protocol specific for each procedure at the time of validation or verification; 7) compare results from the different procedures, equipment, methods being used for the same test either located at the same site or at different sites?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_meUnc = Question::create(array("section_id" => $sec_sec1->id, "name" => "Measurement Uncertainty", "title" => "Measurement Uncertainty", "description" => "How the laboratory will: 1) determine Measurement of uncertainty on measured quantity values (quantitative tests); 2) define the performance requirements for the measurement uncertainty (e.g Standard Deviation; Clinical decision points)? <i><strong>Refer to Question 5.4 on this checklist</strong></i>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_bioRef = Question::create(array("section_id" => $sec_sec1->id, "name" => "Biological Reference Intervals or Clinical Decision Values", "title" => "Biological Reference Intervals or Clinical Decision Values", "description" => "How the laboratory will: 1) define the biological reference intervals; 2) document the source of the reference intervals; 3) communicate changes to the users?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_docExPro = Question::create(array("section_id" => $sec_sec1->id, "name" => "Documentation of examination procedures", "title" => "Documentation of examination procedures", "description" => "How the laboratory will: 1) format general and technical Standard Operating Procedures; 2) define the minimum requirements for a SOP?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labContPro = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Contingency Plan", "title" => "Laboratory Contingency Plan", "description" => "How the laboratory will ensure that there are no interruption to services in the event of: 1)  staff shortage; 2) equipment breakdown; 3) prolonged power outages; 4) stock outs of reagents and consumables; 5) fire, natural disasters e.g. severe weather or floods, bomb threat or civil disturbances; 7) LIS failure?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_QCQA = Question::create(array("section_id" => $sec_sec1->id, "name" => "Quality Control Quality Assurance", "title" => "Quality Control Quality Assurance", "description" => "How the laboratory will: 1) use IQC and EQA (Inter laboratory comparison); 2) define the frequency of processing IQC; 3) define the acceptable ranges; 4) Evaluate and monitor laboratory performance using EQA and QC data; 5) troubleshoot unacceptable EQA and QC; 6) compare results using different procedures, equipment and sites; 7) notify users of any differences in comparability of results?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_repRelRes = Question::create(array("section_id" => $sec_sec1->id, "name" => "Reporting and Release of Results", "title" => "Reporting and Release of Results", "description" => "How the laboratory will : 1) issue standardized report (define the format and medium) ; 2) review patient results; 3) communicate patient results including alert, urgent and critical results; 4) ensure release of results to authorized persons; 5) amend reports; 6) issue of amended reports; 7) store patient results; 8) maintain patient results. <i><strong>(Refer to Question 9.3 of this checklist)</strong></i>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_lis = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Information System (LIS) (Computerized or non-computerized)", "title" => "Laboratory Information System (LIS) (Computerized or non-computerized)", "description" => "How the laboratory will : 1) select a LIS; 2) verify /validate the LIS; 3) define authorities and responsibilities for the management and use of the information system; 4) ensure patient confidentiality is maintained at all times; 5) maintain the system; 6) back-up data; 7) safeguard against tempering by unauthorized users?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labSafeMan = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Safety Manual", "title" => "Laboratory Safety Manual", "description" => "How the laboratory will: 1) ensure all safety measures are implemented at the laboratory as applicable to national and international guidelines and regulations?<i><strong>(Refer to section 12 of this checklist for the contents of a safety manual)</strong></i>", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_poSopsA = Question::create(array("section_id" => $sec_sec1->id, "name" => "Policy and SOPs Accessibility", "title" => "1.6 Policy and SOPs Accessibility", "description" => "Are policies and SOPs easily accessible/available to all staff and written in a language commonly understood by respective staff?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_poSopsComm = Question::create(array("section_id" => $sec_sec1->id, "name" => "Policies and SOPs Communication", "title" => "1.7 Policies and SOPs Communication", "description" => "Is there documented evidence that all relevant policies and SOPs have been communicated to and are understood and implemented by all staff as related to their responsibilities?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_docConLog = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document Control Log", "title" => "1.8 Document Control Log", "description" => "Are policies and procedures dated to reflect when it was put into effect, its location, when it was reviewed and when it was discontinued?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_discPoSops = Question::create(array("section_id" => $sec_sec1->id, "name" => "Discontinued Policies and SOPs", "title" => "1.9 Discontinued Policies and SOPs", "description" => "Are invalid or discontinued policies and procedures clearly marked / identified and removed from use and one copy retained for reference purposes?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_dataFiles = Question::create(array("section_id" => $sec_sec1->id, "name" => "Data Files", "title" => "1.10 Data Files", "description" => "Are test results, technical and quality records, invalid or discontinued policies and procedures archived for a specified time period in accordance with national/international guidelines?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_arcResA = Question::create(array("section_id" => $sec_sec1->id, "name" => "Archived Results Accessibility", "title" => "1.11 Archived Results Accessibility", "description" => "Is there an archiving system that allows for easy and timely retrieval of archived records and results?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        //  Section 2 - Management Review
        $question_quaTechRecRev = Question::create(array("section_id" => $sec_sec2->id, "name" => "Routine Review of Quality and Technical Records", "title" => "2.1 Routine Review of Quality and Technical Records", "description" => "Does the laboratory routinely perform a documented review of all quality and technical records? Does the laboratory review include the following?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_prevActItems = Question::create(array("section_id" => $sec_sec2->id, "name" => "Follow-up of action items from previous reviews", "title" => "", "description" => "a) Follow-up of action items from previous reviews", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_corrActStatus = Question::create(array("section_id" => $sec_sec2->id, "name" => "Status of corrective actions taken", "title" => "", "description" => "b) Status of corrective actions taken and required preventive actions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_repFromPersonnel = Question::create(array("section_id" => $sec_sec2->id, "name" => "Reports from personnel", "title" => "", "description" => "c) Reports from personnel", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_envMonLog = Question::create(array("section_id" => $sec_sec2->id, "name" => "Environmental monitoring log sheets", "title" => "", "description" => "d) Environmental monitoring log sheets", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_speRejLog = Question::create(array("section_id" => $sec_sec2->id, "name" => "Specimen rejection logbook", "title" => "", "description" => "e) Specimen rejection logbook", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_equiCalibManRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Equipment calibration and maintenance records", "title" => "", "description" => "f) Equipment calibration and maintenance records", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_iqcRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "IQC records across all test areas", "title" => "", "description" => "g) IQC records across all test areas", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ptIntLabCo = Question::create(array("section_id" => $sec_sec2->id, "name" => "PTs and other forms of Inter-laboratory comparisons", "title" => "", "description" => "h) Outcomes of PTs and other forms of Inter-laboratory comparisons", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qInd = Question::create(array("section_id" => $sec_sec2->id, "name" => "Quality indicators", "title" => "", "description" => "i) Quality indicators", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_custCompFeed = Question::create(array("section_id" => $sec_sec2->id, "name" => "Customer complaints and feedback", "title" => "", "description" => "j) Customer complaints and feedback", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_impProRes = Question::create(array("section_id" => $sec_sec2->id, "name" => "Results of improvement projects", "title" => "", "description" => "k) Results of improvement projects", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_revActPlanDoc = Question::create(array("section_id" => $sec_sec2->id, "name" => "Documentation of review and action planning", "title" => "", "description" => "l) Documentation of review and action planning with staff for resolution and follow-up review", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_manRev = Question::create(array("section_id" => $sec_sec2->id, "name" => "Management Review", "title" => "2.2 Management Review", "description" => "Does the laboratory management perform a review of the quality system at a management review meeting at least annually?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_perRev = Question::create(array("section_id" => $sec_sec2->id, "name" => "Periodic Reviews", "title" => "", "description" => "a) The periodic review of requests, and suitability of procedures and sample requirements", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_feedAssess = Question::create(array("section_id" => $sec_sec2->id, "name" => "Assessment Feedback", "title" => "", "description" => "b) Assessment of user feedback", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_staffSugg = Question::create(array("section_id" => $sec_sec2->id, "name" => "Staff suggestions", "title" => "", "description" => "c) Staff suggestions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_inAud = Question::create(array("section_id" => $sec_sec2->id, "name" => "Internal audits", "title" => "", "description" => "d) Internal audits", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_rskMan = Question::create(array("section_id" => $sec_sec2->id, "name" => "Risk management", "title" => "", "description" => "e) Risk management", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_quaInd = Question::create(array("section_id" => $sec_sec2->id, "name" => "Use of quality indicators", "title" => "", "description" => "f) Use of quality indicators", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_extAssess = Question::create(array("section_id" => $sec_sec2->id, "name" => "Assessments by external organizations", "title" => "", "description" => "g) Assessments by external organizations", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_interLab = Question::create(array("section_id" => $sec_sec2->id, "name" => "Results of participation in inter-laboratory", "title" => "", "description" => "h) Results of participation in inter-laboratory comparison programmes (PT/EQA)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_monResConf = Question::create(array("section_id" => $sec_sec2->id, "name" => "Monitoring and resolution of complaints", "title" => "", "description" => "i) Monitoring and resolution of complaints", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_suppPerf = Question::create(array("section_id" => $sec_sec2->id, "name" => "Performance of suppliers", "title" => "", "description" => "j) Performance of suppliers", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_idConNon = Question::create(array("section_id" => $sec_sec2->id, "name" => "Identification and control of nonconformities", "title" => "", "description" => "k) Identification and control of nonconformities", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_contImp = Question::create(array("section_id" => $sec_sec2->id, "name" => "Continual Improvement", "title" => "", "description" => "l) Results of continual improvement including, current status of corrective actions and preventive actions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_followUp = Question::create(array("section_id" => $sec_sec2->id, "name" => "Follow-up actions", "title" => "", "description" => "m) Follow-up actions from previous management reviews", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_volScope = Question::create(array("section_id" => $sec_sec2->id, "name" => "Changes in volume and scope", "title" => "", "description" => "n) Changes in the volume and scope of work, personnel, and premises that could affect the quality management system", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_recForImpro = Question::create(array("section_id" => $sec_sec2->id, "name" => "Recommendations for Improvement", "title" => "", "description" => "o) Recommendations for improvement, including technical requirements", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_quaObQuaPo = Question::create(array("section_id" => $sec_sec2->id, "name" => "Quality objectives and quality policy", "title" => "", "description" => "p) Review of quality objectives and the quality policy for appropriateness and continuous improvement", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_revOutRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Management Review recorded", "title" => "", "description" => "q) Are management review outputs recorded?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_mrMeet = Question::create(array("section_id" => $sec_sec2->id, "name" => "MR meeting", "title" => "", "description" => "r) Does the output records of the MR meeting capture decisions made, persons responsible for actions to be taken and timeframes?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_repAddRes = Question::create(array("section_id" => $sec_sec2->id, "name" => "Reports address resources", "title" => "", "description" => "s) Does the report address resources required (human, financial, material)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_refToImpro = Question::create(array("section_id" => $sec_sec2->id, "name" => "Refer to improvement", "title" => "", "description" => "t) Does it refer to improvement for the users?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_effQuaSys = Question::create(array("section_id" => $sec_sec2->id, "name" => "Effectiveness of quality system", "title" => "", "description" => "u) Does it refer to improvement of the effectiveness of the quality system?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_quaAppro = Question::create(array("section_id" => $sec_sec2->id, "name" => "Quality appropriateness", "title" => "", "description" => "v) Were the quality objectives and the quality policy reviewed for appropriateness and continuous improvement?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_mrComm = Question::create(array("section_id" => $sec_sec2->id, "name" => "MR communication", "title" => "", "description" => "2.3 Are findings and actions from MR communicated to the relevant staff?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_mrComp = Question::create(array("section_id" => $sec_sec2->id, "name" => "MR completed", "title" => "", "description" => "2.4 Does lab management ensure actions from MR are completed within defined timeframes?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        //  Section 3 - Organization & Personnel
        $question_duRoDaRo = Question::create(array("section_id" => $sec_sec3->id, "name" => "Duty Roster And Daily Routine", "title" => "3.1 Duty Roster And Daily Routine", "description" => "Does the laboratory have a duty roster that covers normal and after hours?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_orgChart = Question::create(array("section_id" => $sec_sec3->id, "name" => "Organizational Chart and External/Internal Reporting Systems", "title" => "3.2 Organizational Chart and External/Internal Reporting Systems", "description" => "Is an organizational chart available that indicates the relationship between the laboratory and its parent organization?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labDir = Question::create(array("section_id" => $sec_sec3->id, "name" => "Laboratory Director", "title" => "3.3 Laboratory Director", "description" => "Is the laboratory directed by a person(s) with the competency, delegated responsibility to perform the following;", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_effLead = Question::create(array("section_id" => $sec_sec3->id, "name" => "Effective Leadership", "title" => "", "description" => "a) Provide  effective  leadership,  budgeting  and planning", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_stakeComm = Question::create(array("section_id" => $sec_sec3->id, "name" => "Communication with stakeholders", "title" => "", "description" => "b) Communicate with stakeholders", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_adCompSta = Question::create(array("section_id" => $sec_sec3->id, "name" => "Adequate and competent staff", "title" => "", "description" => "c) Ensure adequate competent staff", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qmsImp = Question::create(array("section_id" => $sec_sec3->id, "name" => "QMS implementation", "title" => "", "description" => "d) Ensure the implementation of the QMS", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labSuppMon = Question::create(array("section_id" => $sec_sec3->id, "name" => "Monitoring of lab supplies", "title" => "", "description" => "e) Selection and monitoring of lab supplies", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_refLabMon = Question::create(array("section_id" => $sec_sec3->id, "name" => "Monitoring of referral labs", "title" => "", "description" => "f) Selection and monitoring of referral labs", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_safeLabEnv = Question::create(array("section_id" => $sec_sec3->id, "name" => "Safe Lab Environment", "title" => "", "description" => "g) Ensure a safe lab environment", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_advSer = Question::create(array("section_id" => $sec_sec3->id, "name" => "Advisory Services", "title" => "", "description" => "h) Advisory services", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_profDevProg = Question::create(array("section_id" => $sec_sec3->id, "name" => "Professional development programmes", "title" => "", "description" => "i) Provide professional development programs for laboratory staff", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_addCompReq = Question::create(array("section_id" => $sec_sec3->id, "name" => "Address complaint requests", "title" => "", "description" => "j) Address complaints, requests or suggestions from staff and/or lab users", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_contPlan = Question::create(array("section_id" => $sec_sec3->id, "name" => "Contingency Plan", "title" => "", "description" => "k) Design and implement a contingency plan", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qmsOversight = Question::create(array("section_id" => $sec_sec3->id, "name" => "Quality Management System Oversight", "title" => "3.4 Quality Management System Oversight", "description" => "Is there a quality officer/manager with delegated responsibility to oversee compliance with the quality management system?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_jobDesc = Question::create(array("section_id" => $sec_sec3->id, "name" => "Job Description", "title" => "", "description" => "a) Is there an appointment letter, job description available or terms of reference?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qmsProcess = Question::create(array("section_id" => $sec_sec3->id, "name" => "QMS Processes", "title" => "", "description" => "b) Does the quality manager ensure that processes needed for the quality management system are established, implemented, and maintained?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qmReport = Question::create(array("section_id" => $sec_sec3->id, "name" => "QM Report", "title" => "", "description" => "c) Does the QM report to management at which decisions relating to quality are made?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qmPromo = Question::create(array("section_id" => $sec_sec3->id, "name" => "QM Promote awareness", "title" => "", "description" => "d) Does the QM promote awareness of users’ needs and requirements throughout the organization?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_qmPart = Question::create(array("section_id" => $sec_sec3->id, "name" => "QM Participate in reviews", "title" => "", "description" => "e) Does the QM participate in management reviews?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_perFilSys = Question::create(array("section_id" => $sec_sec3->id, "name" => "Personnel Filing System", "title" => "3.5 Personnel Filing System", "description" => "Are records of personnel maintained and do they include the following?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_edProfQua = Question::create(array("section_id" => $sec_sec3->id, "name" => "Educational and professional qualifications", "title" => "", "description" => "a) Educational and professional qualifications", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_certOrLic = Question::create(array("section_id" => $sec_sec3->id, "name" => "Copy of certification or license to practice, when applicable", "title" => "", "description" => "b) Copy of certification or license to practice, when applicable", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_CV = Question::create(array("section_id" => $sec_sec3->id, "name" => "CV", "title" => "", "description" => "c) Previous work experience e.g. CV", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_jobDescr = Question::create(array("section_id" => $sec_sec3->id, "name" => "Job Description", "title" => "", "description" => "d) Job descriptions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_newStaIntro = Question::create(array("section_id" => $sec_sec3->id, "name" => "Introduction of new staff to the laboratory environment", "title" => "", "description" => "e) Introduction of new staff to the laboratory environment", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_currJob = Question::create(array("section_id" => $sec_sec3->id, "name" => "Current Job Tasks", "title" => "", "description" => "f) Training in current job tasks including vendor training received on -site", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_compeAssess = Question::create(array("section_id" => $sec_sec3->id, "name" => "Competency Assessment", "title" => "", "description" => "g) Competency assessments", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_recContEd = Question::create(array("section_id" => $sec_sec3->id, "name" => "Records of continuing education", "title" => "", "description" => "h) Records of continuing education", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_revStaPerf = Question::create(array("section_id" => $sec_sec3->id, "name" => "Reviews of staff performance", "title" => "", "description" => "i) Reviews of staff performance", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_repOfAcc = Question::create(array("section_id" => $sec_sec3->id, "name" => "Reports of accidents", "title" => "", "description" => "j) Reports of accidents and exposure to occupational hazards", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_immuSta = Question::create(array("section_id" => $sec_sec3->id, "name" => "Immunization status, as applicable relevant to assigned duties", "title" => "", "description" => "k) Immunization status, as applicable relevant to assigned duties", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_empLetter = Question::create(array("section_id" => $sec_sec3->id, "name" => "Letter of employment or appointment", "title" => "", "description" => "l) Letter of employment or appointment", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_medSurvRec = Question::create(array("section_id" => $sec_sec3->id, "name" => "Employee medical surveillance records", "title" => "", "description" => "m) Employee medical surveillance records", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labStaffTra = Question::create(array("section_id" => $sec_sec3->id, "name" => "Laboratory Staff Training", "title" => "3.6 Laboratory Staff Training", "description" => "Is there a system for training that covers the following?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_qms = Question::create(array("section_id" => $sec_sec3->id, "name" => "The quality management system", "title" => "", "description" => "a) The quality management system", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_assWork = Question::create(array("section_id" => $sec_sec3->id, "name" => "Assigned work processes, procedures and tasks", "title" => "", "description" => "b) Assigned work processes, procedures and tasks", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_appLis = Question::create(array("section_id" => $sec_sec3->id, "name" => "The applicable laboratory information system", "title" => "", "description" => "c) The applicable laboratory information system", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_healthSafety = Question::create(array("section_id" => $sec_sec3->id, "name" => "Health and safety, including the prevention or containment of the effects of adverse incidents", "title" => "", "description" => "d) Health and safety, including the prevention or containment of the effects of adverse incidents", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labEth = Question::create(array("section_id" => $sec_sec3->id, "name" => "Laboratory Ethics", "title" => "", "description" => "e) Laboratory Ethics", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_confPatInfo = Question::create(array("section_id" => $sec_sec3->id, "name" => "Confidentiality of patient information", "title" => "", "description" => "f) Confidentiality of patient information", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_supTra = Question::create(array("section_id" => $sec_sec3->id, "name" => "Is there supervision for persons undergoing training", "title" => "", "description" => "g) Is there supervision for persons undergoing training", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_contMedEd = Question::create(array("section_id" => $sec_sec3->id, "name" => "Continuous medical education", "title" => "", "description" => "h) Continuous medical education", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_trainPro = Question::create(array("section_id" => $sec_sec3->id, "name" => "Review of effectiveness of the training program", "title" => "", "description" => "i) Review of effectiveness of the training program", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_staffCompAudit = Question::create(array("section_id" => $sec_sec3->id, "name" => "Staff Competency Assessment and retraining", "title" => "3.7 Staff Competency Assessment and retraining", "description" => "Is there a system for competency assessment that covers the following?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_defCrit = Question::create(array("section_id" => $sec_sec3->id, "name" => "Defined Criteria", "title" => "", "description" => "a) Are competency assessments performed according defined criteria", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_newHire = Question::create(array("section_id" => $sec_sec3->id, "name" => "New hires", "title" => "", "description" => "b) New hires", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_existSta = Question::create(array("section_id" => $sec_sec3->id, "name" => "Existing staff", "title" => "", "description" => "c) Existing staff", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_reTrareAss = Question::create(array("section_id" => $sec_sec3->id, "name" => "Retraining and re-assessment where needed", "title" => "", "description" => "d) Retraining and re-assessment where needed", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_staffMeet = Question::create(array("section_id" => $sec_sec3->id, "name" => "Staff Meetings", "title" => "3.8 Staff Meetings", "description" => "Are staff meetings held regularly and do the meetings address the following items?", "question_type" => "0", "score" => "4", "user_id" => "1"));
        $question_prevStaMeet = Question::create(array("section_id" => $sec_sec3->id, "name" => "Follow-up of action items from previous staff meeting", "title" => "", "description" => "a) Follow-up of action items from previous staff meeting", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_sysRecPro = Question::create(array("section_id" => $sec_sec3->id, "name" => "Systemic and or recurrent problems", "title" => "", "description" => "b) Systemic and or recurrent problems and issues addressed, including actions to prevent recurrence", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_complaints = Question::create(array("section_id" => $sec_sec3->id, "name" => "Complaints", "title" => "", "description" => "c) Complaints", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_commOnSops = Question::create(array("section_id" => $sec_sec3->id, "name" => "Communication on reviewed/revised/redundant SOPs", "title" => "", "description" => "d) Communication on reviewed/revised/redundant SOPs", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_priorCorrAct = Question::create(array("section_id" => $sec_sec3->id, "name" => "Review of results from prior corrective actions", "title" => "", "description" => "e) Review of results from prior corrective actions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_evalOfImpro = Question::create(array("section_id" => $sec_sec3->id, "name" => "Discussion and evaluation of improvement topics/projects", "title" => "", "description" => "f) Discussion and evaluation of improvement topics/projects", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_hospMeetFeed = Question::create(array("section_id" => $sec_sec3->id, "name" => "Feedback given by staff", "title" => "", "description" => "g) Feedback given by staff that have attended hospital meetings, external meetings, training, conferences, workshops, etc.", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_relOfRep = Question::create(array("section_id" => $sec_sec3->id, "name" => "Relay of reports", "title" => "", "description" => "h) Relay of reports and updates from lab attendance at meetings with clinicians (the use of lab services and/or attendance at clinical rounds)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_recMonMeetNotes = Question::create(array("section_id" => $sec_sec3->id, "name" => "Meeting notes", "title" => "", "description" => "i) Recording and monitoring of meeting notes for progress on issues.", "question_type" => "0", "score" => "0", "user_id" => "1"));
        //  Section 4 - Client Management and Customer Service
        $question_advTraQS = Question::create(array("section_id" => $sec_sec4->id, "name" => "Advice and Training by Qualified Staff", "title" => "4.1 Advice and Training by Qualified Staff", "description" => "Do staff members with appropriate professional qualifications provide clients with advice and/or training regarding required types of samples, choice of examinations, repeat frequency, and interpretation of results?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_resOfComp = Question::create(array("section_id" => $sec_sec4->id, "name" => "Resolution of Complaints", "title" => "4.2 Resolution of Complaints", "description" => "Does the laboratory investigate (review) and resolves of customer complaints?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labHandbook = Question::create(array("section_id" => $sec_sec4->id, "name" => "Laboratory Handbook for Clients", "title" => "4.3 Laboratory Handbook for Clients - information to users", "description" => "Is there a laboratory handbook for laboratory users that includes information on location of the lab, services offered, laboratory operatin g times, instructions on completion of request forms, instruction for preparation of the patient; sample collection including patient collected samples, transport, agreed turnaround times, acceptance and rejection criteria, availability of advice on examination and interpretation of results; lab policy on protection of personal information, laboratory complaints procedure.", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_commPoOnDelays = Question::create(array("section_id" => $sec_sec4->id, "name" => "Communication Policy on Delays in Service", "title" => "4.4 Communication Policy on Delays in Service", "description" => "Is timely, documented notification provided to customers when the laboratory experiences delays or interruptions in testing (due to equipment failure, stock outs, staff levels, etc.) or finds it necessary to change examination procedures and when testing resumes?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_evalTool = Question::create(array("section_id" => $sec_sec4->id, "name" => "Evaluation Tool and Follow up", "title" => "4.5 Evaluation Tool and Follow up", "description" => "Is there a tool for regularly evaluating client satisfaction and is the feedback received effectively utilized to improve services?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        //  Section 5 - Equipment
        $question_properEquiPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Adherence to Proper Equipment Protocol", "title" => "5.1 Adherence to Proper Equipment Protocol", "description" => "Is equipment installed and placed as specified in the operator’s manuals and uniquely labeled or marked?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipOper = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Operation", "title" => "5.2 Equipment Operation", "description" => "Are equipment operated by trained, competent and authorized personnel?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipMethVal = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment and Method Validation", "title" => "5.3 Equipment and Method Validation/Verification and Documentation", "description" => "Are newly introduced equipment and methods validated/verified on-site and is documented evidence available?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_specValVerPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Specific validation/verification protocol", "title" => "", "description" => "a) Are specific verification/validation protocols in place for each equipment and examination procedure?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_valPerf = Question::create(array("section_id" => $sec_sec5->id, "name" => "Validation performed", "title" => "", "description" => "b)  Is validation performed for all laboratory designed or developed methods, standard methods used outside their intended scope and validated methods that are subsequently modified?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_valInfo = Question::create(array("section_id" => $sec_sec5->id, "name" => "Validation information obtained", "title" => "", "description" => "c) Has validation information been obtained from the manufacturer/method developer as part of the verification?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_perfCharac = Question::create(array("section_id" => $sec_sec5->id, "name" => "Performance characteristics selected", "title" => "", "description" => "d) Have performance characteristics been appropriately selected and evaluated as per intended use?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_adeqValVer = Question::create(array("section_id" => $sec_sec5->id, "name" => "Adequate validation/verification", "title" => "", "description" => "e) Were the verification/validation studies appropriate and adequate?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_dataAn = Question::create(array("section_id" => $sec_sec5->id, "name" => "Analysis of data", "title" => "", "description" => "f) Was the analysis of data appropriate for the selected performance characteristics?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_valVerRep = Question::create(array("section_id" => $sec_sec5->id, "name" => "Validation/Verification Reports", "title" => "", "description" => "g) Have the verification/validation results/reports been reviewed and approved by an authorised person?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_meQuaTests = Question::create(array("section_id" => $sec_sec5->id, "name" => "Measurement uncertainty of measured quantity tests", "title" => "5.4 Measurement uncertainty of measured quantity tests", "description" => "Does the laboratory have documented estimates of measurement of uncertainty (UM)?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_quantitative = Question::create(array("section_id" => $sec_sec5->id, "name" => "Quantitative measurement procedures", "title" => "", "description" => "a) Has the laboratory calculated the measurement uncertainty for each quantitative measurement procedure?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_defPerfReq = Question::create(array("section_id" => $sec_sec5->id, "name" => "Defined Performance Requirements", "title" => "", "description" => "b)  Has the laboratory defined the performance requirements (factors that affect the UM) for the measurement uncertainty of each measurement procedure and regularly review estimates of measurement uncertainty?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_calMeasure = Question::create(array("section_id" => $sec_sec5->id, "name" => "Calculated Measure of Uncertainty", "title" => "", "description" => "c) Does the lab make its calculated measurement of uncertainty available to its users upon request?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_equipRecMan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Record Maintenance", "title" => "5.5 Equipment Record Maintenance", "description" => "Is current equipment inventory data available on all equipment in the laboratory?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipName = Question::create(array("section_id" => $sec_sec5->id, "name" => "Name of equipment", "title" => "", "description" => "a) Name of equipment", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_manfCont = Question::create(array("section_id" => $sec_sec5->id, "name" => "Manufacturer's contact details", "title" => "", "description" => "b) Manufacturer’s or authorized supplier contact details", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_condReceived = Question::create(array("section_id" => $sec_sec5->id, "name" => "Condition received (new, used, reconditioned)", "title" => "", "description" => "c) Condition received (new, used, reconditioned)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_serialNo = Question::create(array("section_id" => $sec_sec5->id, "name" => "Serial number", "title" => "", "description" => "d) Serial number", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_dateOfPur = Question::create(array("section_id" => $sec_sec5->id, "name" => "Date of receiving", "title" => "", "description" => "e) Date of receiving", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_outOfSer = Question::create(array("section_id" => $sec_sec5->id, "name" => "Date out of service", "title" => "", "description" => "f) Where equipment is obsolete, date when put 'out of service'", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_dateSerEntry = Question::create(array("section_id" => $sec_sec5->id, "name" => "Date of entry into service", "title" => "", "description" => "g) Date of entry into service(after validation / verification)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_location = Question::create(array("section_id" => $sec_sec5->id, "name" => "Location", "title" => "", "description" => "h) Location", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_equipManRec = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Maintenance Records", "title" => "5.6 Equipment Maintenance Records", "description" => "Is relevant equipment service information readily available in the laboratory?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_serviceContInf = Question::create(array("section_id" => $sec_sec5->id, "name" => "Service contract information", "title" => "", "description" => "a) Service contract information", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_serviceProCont = Question::create(array("section_id" => $sec_sec5->id, "name" => "Contact details for service provider", "title" => "", "description" => "b) Contact details for service provider", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_decontaRec = Question::create(array("section_id" => $sec_sec5->id, "name" => "Decontamination Records", "title" => "", "description" => "c) Decontamination Records", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_prevManRec = Question::create(array("section_id" => $sec_sec5->id, "name" => "Preventative maintenance records", "title" => "", "description" => "d) Engineer or service provider preventative maintenance records", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_lastSerDate = Question::create(array("section_id" => $sec_sec5->id, "name" => "Last date of service", "title" => "", "description" => "e) Last date of service", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_nextSerDate = Question::create(array("section_id" => $sec_sec5->id, "name" => "Next date of service", "title" => "", "description" => "f) Next date of service", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_defEquip = Question::create(array("section_id" => $sec_sec5->id, "name" => "Defective Equipment Waiting for Repair", "title" => "5.7 Defective Equipment Waiting for Repair", "description" => "Is defective equipment, waiting for repair not used and clearly labelled?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_obsoEquipPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Obsolete Equipment Procedures", "title" => "5.8 Obsolete Equipment Procedures", "description" => "Is non-functioning equipment appropriately labeled and removed from the laboratory or path of workflow following the equipment management policies and procedures?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipCalibPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Adherence to Equipment Calibration Protocol", "title" => "5.9 Equipment Calibration and Metrological traceability Protocol", "description" => "Is routine calibration of laboratory equipment (including pipettes, centrifuges, balances, and thermometers) scheduled, as indicated on the equipment, and verified?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_routineCalib = Question::create(array("section_id" => $sec_sec5->id, "name" => "Routine Calibration", "title" => "", "description" => "a) Is routine calibration of laboratory ancillary equipment (including pipettes, centrifuges, balances, and thermometers) scheduled, at minimum following manufacturer recommendations and verified?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_traceCalib = Question::create(array("section_id" => $sec_sec5->id, "name" => "Traceable Calibration", "title" => "", "description" => "b) Is the calibration traceable (e.g. use of reference materials and equipment like certified thermometers, tachometer?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_reviewCalib = Question::create(array("section_id" => $sec_sec5->id, "name" => "Review of Calibration", "title" => "", "description" => "c) Is there evidence of review of calibrations certificates/results by the laboratory before acceptance back into use?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_certRefMat = Question::create(array("section_id" => $sec_sec5->id, "name" => "Certified Reference Materials", "title" => "", "description" => "d) Is certified reference materials, examination and calibration by another procedure, use of mutual consent standards or methods used for in house calibrations?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_equipPrevMan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Preventive Maintenance", "title" => "5.10 Equipment Preventive Maintenance", "description" => "Is routine preventive maintenance performed on all equipment and recorded according to manufacturer’s minimum requirements?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipSerMan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Service Maintenance", "title" => "5.11 Equipment Service Maintenance", "description" => "Is equipment routinely serviced according to schedule as per the minimum manufacturer recommendations by qualified and competent personnel and is this information documented in appropriate logs?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipMalf = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Malfunction", "title" => "5.12 Equipment Malfunction - Response and Documentation", "description" => "Is equipment malfunction resolved by the effectiveness of the corrective action program and the associated root cause analysis?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipRepMon = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Repair Monitoring and Documentation", "title" => "5.13 Equipment Repair Monitoring and Documentation", "description" => "Are repair orders monitored to determine if the service is completed? Does the laboratory verify and document that it is in proper working order before being put it back into service?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_repOrders = Question::create(array("section_id" => $sec_sec5->id, "name" => "Repair Orders", "title" => "", "description" => "a) Are repair orders monitored to determine if the service is completed?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_verDocEquip = Question::create(array("section_id" => $sec_sec5->id, "name" => "Verify and Document Equipment", "title" => "", "description" => "b) Does the laboratory verify and document the equipment is in proper working order before being put it back into service?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_equipFailPlan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Failure - Contingency Plan", "title" => "5.14 Equipment Failure - Contingency Plan", "description" => "Is there a functional back-up system that prevents interruption of lab services?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_manManual = Question::create(array("section_id" => $sec_sec5->id, "name" => "Manufacturer's Operator Manual", "title" => "5.15 Manufacturer's Operator Manual", "description" => "Are the equipment manufacturer’s operator manuals readily available to testing staff, and where possible, available in the language understood by staff?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labTestSer = Question::create(array("section_id" => $sec_sec5->id, "name" => "Laboratory Testing Services", "title" => "5.16 Laboratory Testing Services", "description" => "Has the laboratory provided uninterrupted testing services, with no disruptions due to equipment failure in the last year (or since the last audit)?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        //  Section 6 - Internal Audit
        $question_internalAudits = Question::create(array("section_id" => $sec_sec6->id, "name" => "Internal Audits", "title" => "6.1 Internal Audits", "description" => "Are internal audits conducted at intervals as defined in the quality manual and do these audits address areas important to patient care?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_allQMS = Question::create(array("section_id" => $sec_sec6->id, "name" => "All QMS audited", "title" => "", "description" => "a) Is there an audit plan/schedule that ensures all activities of the QMS are audited?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_minConfOfIntr = Question::create(array("section_id" => $sec_sec6->id, "name" => "Minimal conflict of interest", "title" => "", "description" => "b) Are audits being carried with minimal conflict of interest e.g. where possible, carried out by persons who are not involved in lab activities in the section being audited?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_audPers = Question::create(array("section_id" => $sec_sec6->id, "name" => "Audit personnel trained", "title" => "", "description" => "c) Are the personnel conducting the internal audits trained with proven competency in auditing managerial and/or technical requirements?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_causeAnalPerf = Question::create(array("section_id" => $sec_sec6->id, "name" => "Cause Analysis Performed", "title" => "", "description" => "d) Is cause analysis performed for nonconformities/noted deficiencies?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_inAudFind = Question::create(array("section_id" => $sec_sec6->id, "name" => "Internal Audit Findings Presented", "title" => "", "description" => "e) Are internal audit findings documented and presented to the laboratory management and relevant staff for review?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_auditRecomm = Question::create(array("section_id" => $sec_sec6->id, "name" => "Audit Recommendations and Action Plan & Follow up", "title" => "6.2 Audit Recommendations and Action Plan & Follow up", "description" => "", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_audRepGen = Question::create(array("section_id" => $sec_sec6->id, "name" => "Are internal audits reports generated?", "title" => "", "description" => "a) Are internal audits reports generated?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_corrPrevAct = Question::create(array("section_id" => $sec_sec6->id, "name" => "Corrective/Preventive Actions", "title" => "", "description" => "b) Are recommendations for corrective/preventive actions made based on audit findings?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_timeframe = Question::create(array("section_id" => $sec_sec6->id, "name" => "Follow-up within timeframe", "title" => "", "description" => "c) Is an action plan developed with clear timelines, assigned personnel & documented follow-up within the timeframe defined by the laboratory?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_riskManage = Question::create(array("section_id" => $sec_sec6->id, "name" => "Risk Management", "title" => "6.3 Risk Management", "description" => "Are assessment of potential pitfalls performed for all laboratory processes including pre examination, examination and post examination?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_assessPitfalls = Question::create(array("section_id" => $sec_sec6->id, "name" => "Assess Potential pitfalls", "title" => "", "description" => "a) Documented assessment of potential pitfalls for all processes", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_redPitfalls = Question::create(array("section_id" => $sec_sec6->id, "name" => "Reduce Potential Pitfalls", "title" => "", "description" => "b) Documented actions taken to reduce or eliminate identified potential pitfalls", "question_type" => "0", "score" => "0", "user_id" => "1"));
        //  Section 7 - Purchasing and Inventory
        $question_invBudget = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory and Budgeting System", "title" => "7.1 Inventory and Budgeting System", "description" => "Is there a system for accurately forecasting needs for supplies and reagents?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_specForSupp = Question::create(array("section_id" => $sec_sec7->id, "name" => "", "title" => "7.2 Specification for supplies/consumables", "description" => "Does the laboratory provide specification for their supplies and consumables that are required when placing a requisition?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_serSuppPerfRev = Question::create(array("section_id" => $sec_sec7->id, "name" => "Service Supplier Performance Review", "title" => "7.3 Service Supplier Performance Review", "description" => "Does the lab monitor the performance of the suppliers to ensure that the stated criteria are met?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_invCon = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory Control", "title" => "7.4 Inventory Control", "description" => "Does the lab maintain records for each reagent and consumable that contributes to the performance of examinations. These records shall include but not be limited to the following:", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_reaCon = Question::create(array("section_id" => $sec_sec7->id, "name" => "Reagent or consumable", "title" => "", "description" => "a) Identity of the reagent or consumable?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_batchLot = Question::create(array("section_id" => $sec_sec7->id, "name" => "Batch code or lot number?", "title" => "", "description" => "b) Batch code or lot number?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_manSuppName = Question::create(array("section_id" => $sec_sec7->id, "name" => "Manufacturer or Supplier Name", "title" => "", "description" => "c) Manufacturer or supplier name and contact information?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_receiptDate = Question::create(array("section_id" => $sec_sec7->id, "name" => "Date of receiving", "title" => "", "description" => "d) Date of receiving, the expiry date, date of entering into service and, where applicable, the date the material was taken out of service?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_manPack = Question::create(array("section_id" => $sec_sec7->id, "name" => "Manufacturer instructions", "title" => "", "description" => "e) Manufacturer's instruction/package insert?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_inspRec = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inspection records", "title" => "", "description" => "f) Records of inspection of reagents and consumables when received (e.g. acceptable or damaged)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_budgetaryPro = Question::create(array("section_id" => $sec_sec7->id, "name" => "Budgetary Projections", "title" => "7.5 Budgetary Projections", "description" => "Are budgetary projections based on personnel, test, facility and equipment needs, and quality assurance procedures and materials?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_manRevSuppReq = Question::create(array("section_id" => $sec_sec7->id, "name" => "Management Review of Supply Requests", "title" => "7.6 Management Review of Supply Requests", "description" => "Does management review the finalized/approved supply requests?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labInvSys = Question::create(array("section_id" => $sec_sec7->id, "name" => "Laboratory Inventory System", "title" => "7.7 Laboratory Inventory System", "description" => "", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_invRecComp = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory Records Complete", "title" => "", "description" => "a) Are inventory records complete and accurate, with minimum and maximum stock levels denoted and monitored?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_consRate = Question::create(array("section_id" => $sec_sec7->id, "name" => "Consumption Rate", "title" => "", "description" => "b) Is the consumption rate of all reagents and consumables monitored?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_stockCounts = Question::create(array("section_id" => $sec_sec7->id, "name" => "Stock Counts", "title" => "", "description" => "c) Are stock counts routinely performed?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_storageArea = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage Area", "title" => "7.8 Storage Area", "description" => "Are storage areas set up and monitored appropriately?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_storageWellOrg = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage area well-organized", "title" => "", "description" => "a) Is the storage area well-organized and free of clutter?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_desigPlaces = Question::create(array("section_id" => $sec_sec7->id, "name" => "Designated places", "title" => "", "description" => "b) Are there designated places labeled for all inventory items for easy access?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_coldStorage = Question::create(array("section_id" => $sec_sec7->id, "name" => "Adequate cold storage", "title" => "", "description" => "c) Is adequate cold storage available?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_storageAreaMon = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage areas monitored", "title" => "", "description" => "d) Are storage areas monitored as per prescribed storage conditions?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ambientTemp = Question::create(array("section_id" => $sec_sec7->id, "name" => "Ambient temperature", "title" => "", "description" => "e) Is the ambient temperature monitored routinely?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_directSunlight = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage in direct sunlight", "title" => "", "description" => "f) Is storage in direct sunlight avoided?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_adequateVent = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage area adequately ventilated", "title" => "", "description" => "g) Is the storage area adequately ventilated?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_cleanDustPests = Question::create(array("section_id" => $sec_sec7->id, "name" => "Clean and free of dust and pests", "title" => "", "description" => "h) Is the storage area clean and free of dust and pests?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_accessControl = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage areas access-controlled", "title" => "", "description" => "i) Are storage areas access-controlled?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_wastageMin = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory Organization and Wastage Minimization", "title" => "7.9 Inventory Organization and Wastage Minimization", "description" => "Is First-Expiration-First-Out (FEFO) practiced?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_dispExProd = Question::create(array("section_id" => $sec_sec7->id, "name" => "Disposal of Expired Products", "title" => "7.10 Disposal of Expired Products", "description" => "Are expired products labeled and disposed properly?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_prodExpiration = Question::create(array("section_id" => $sec_sec7->id, "name" => "Product Expiration", "title" => "7.11 Product Expiration", "description" => "Are all reagents/test kits in use (and in stock) currently within the manufacturer-assigned expiration dates or within stability?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labTestServices = Question::create(array("section_id" => $sec_sec7->id, "name" => "Laboratory Testing Services", "title" => "7.12 Laboratory Testing Services", "description" => "Has the laboratory provided uninterrupted testing services, with no disruptions due to stock outs in the last year or since last assessment?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        //  Section 8 - Process Control and Internal & External Quality Assurance
        $question_patIdGuide = Question::create(array("section_id" => $sec_sec8->id, "name" => "Patient Identification guidelines", "title" => "8.1 Information for patients and users", "description" => "Are guidelines for patient identification, specimen collection (including client safety), labeling, and transport readily available to persons responsible for primary sample collection?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_adSampInfo = Question::create(array("section_id" => $sec_sec8->id, "name" => "Adequate sample receiving procedures", "title" => "8.2 Does the laboratory adequately collect information needed for examination performance?", "description" => "", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_testReqForm = Question::create(array("section_id" => $sec_sec8->id, "name" => "Test Requisition Form", "title" => "", "description" => "a) Are all test requests accompanied by an acceptable and approved test requisition form (and a transmittal sheet/checklist/manifest where applicable)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ptId = Question::create(array("section_id" => $sec_sec8->id, "name" => "Patient identification", "title" => "", "description" => "b) Does the request form has patient ID including gender, date of birth, location of patient and unique identifier?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_authReq = Question::create(array("section_id" => $sec_sec8->id, "name" => "Authorized requester", "title" => "", "description" => "c) Name, signature or initials of authorized requester", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_exam = Question::create(array("section_id" => $sec_sec8->id, "name" => "Examination requested", "title" => "", "description" => "d) Type of sample and examination requested", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_relInfo = Question::create(array("section_id" => $sec_sec8->id, "name" => "Relevant Information", "title" => "", "description" => "e) Clinically relevant information", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_collDate = Question::create(array("section_id" => $sec_sec8->id, "name" => "Collection date", "title" => "", "description" => "f) Date of sample collection (And time of collection where relevant – where time has an impact on the result)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_receiptTime = Question::create(array("section_id" => $sec_sec8->id, "name" => "DateTime sample receipt", "title" => "", "description" => "g) Date and time of sample receipt", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_consent = Question::create(array("section_id" => $sec_sec8->id, "name" => "Written consent", "title" => "", "description" => "i) Written consent for invasive procedures with increased risk of complications", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_sampRecPro = Question::create(array("section_id" => $sec_sec8->id, "name" => "Adequate sample receiving procedures", "title" => "8.3 Are adequate sample receiving procedures in place?", "description" => "", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_patUniq = Question::create(array("section_id" => $sec_sec8->id, "name" => "Patient Unique Identifier", "title" => "", "description" => "a) Patient Unique Identifier", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_accRejCrit = Question::create(array("section_id" => $sec_sec8->id, "name" => "Acceptance/Rejection Criteria", "title" => "", "description" => "b) Are received specimens evaluated according to acceptance/rejection criteria?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_specLog = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimen log", "title" => "", "description" => "c) Are specimens logged appropriately upon receipt in the laboratory (including date, time, and name of receiving officer)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_verbalReq = Question::create(array("section_id" => $sec_sec8->id, "name" => "Verbal requests", "title" => "", "description" => "d) Are procedures in place to process 'urgent' specimens and verbal requests?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_splitSamp = Question::create(array("section_id" => $sec_sec8->id, "name" => "Split Sample", "title" => "", "description" => "e) When samples are split, can the portions be traced back to the primary sample?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_24hour = Question::create(array("section_id" => $sec_sec8->id, "name" => "24 hour Lab", "title" => "", "description" => "f) If not a 24 hour lab, is there a documented method for handling of specimens received after hours?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_corrWorksta = Question::create(array("section_id" => $sec_sec8->id, "name" => "Correct Workstation", "title" => "", "description" => "g) Are specimens delivered to the correct workstations in a timely manner?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_preExHand = Question::create(array("section_id" => $sec_sec8->id, "name" => "Pre-examination Handling, Preparation and Storage", "title" => "8.4 Pre-examination Handling, Preparation and Storage", "description" => "Where testing does not occur immediately upon arrival in the laboratory, are specimens stored appropriately prior to testing?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_sampTrans = Question::create(array("section_id" => $sec_sec8->id, "name" => "Sample Transportation", "title" => "8.5 Sample Transportation", "description" => "Are specimens either received or referred packaged appropriately according to local and or international regulations and transported within acceptable timeframes and temperature intervals?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_evalRefLabs = Question::create(array("section_id" => $sec_sec8->id, "name" => "Does the laboratory select and evaluate referral Labs and Consultants?", "title" => "8.6 Does the laboratory select and evaluate referral Labs and Consultants?", "description" => "", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_refLabCons = Question::create(array("section_id" => $sec_sec8->id, "name" => "Referral Lab Consultants", "title" => "", "description" => "a) Are there documented reviews and evaluations of referral laboratories and consultants as defined by the laboratory?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_refLabRej = Question::create(array("section_id" => $sec_sec8->id, "name" => "Referral Lab Register", "title" => "", "description" => "b) Is there a register of referral Laboratories and consultants?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_refSpec = Question::create(array("section_id" => $sec_sec8->id, "name" => "Referral Specimen tracked appropriately", "title" => "", "description" => "c) Are referred specimens tracked properly using a logbook, tracking form or electronically?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_docExProc = Question::create(array("section_id" => $sec_sec8->id, "name" => "Documentation of examination procedures", "title" => "8.7 Documentation of Examination Procedures", "description" => "Are examination procedures documented in a language commonly understood by all staff and available in appropriate locations?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_reAcc = Question::create(array("section_id" => $sec_sec8->id, "name" => "Reagents Acceptance Testing", "title" => "8.8 Reagents Acceptance Testing", "description" => "Is each new reagent preparation, new lot number, new shipment of reagents or consumables verified before use and documented?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_quaCon = Question::create(array("section_id" => $sec_sec8->id, "name" => "Quality Control", "title" => "8.9 Quality Control", "description" => "Is internal quality control performed, documented, and verified for all tests/procedures before releasing patient results?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_quaConData = Question::create(array("section_id" => $sec_sec8->id, "name" => "Quality Control Data", "title" => "8.10 Quality Control Data", "description" => "Are QC results monitored and reviewed (including biases and Levy-Jennings charts for quantitative tests)?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_corrAcDoc = Question::create(array("section_id" => $sec_sec8->id, "name" => "Corrective Actions Documentation", "title" => "", "description" => "a) Is there documentation of corrective action taken when quality control results exceed the acceptable range or reviews identify non conformities in a timely manner?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_resEval = Question::create(array("section_id" => $sec_sec8->id, "name" => "Control Results Evaluation", "title" => "", "description" => "b) Does the Lab evaluate the results from the patient samples that were examined after the last successful quality control event", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_compExRes = Question::create(array("section_id" => $sec_sec8->id, "name" => "Comparability of Examination Results", "title" => "8.11   Comparability of Examination Results", "description" => "Does the laboratory compare results of the same test performed with different procedures and equipment?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_diffProc = Question::create(array("section_id" => $sec_sec8->id, "name" => "Different Procedures", "title" => "", "description" => "a) Where there is more than one procedure for the same measure, does the laboratory compare results from the different procedures, equipment or methods?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_compStud = Question::create(array("section_id" => $sec_sec8->id, "name" => "Comparative studies", "title" => "", "description" => "b) Does the lab discuss, document and act upon (including notifying users) problems or deficiencies from these comparison studies?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_envCondCheck = Question::create(array("section_id" => $sec_sec8->id, "name" => "Are environmental conditions checked and reviewed accurately?", "title" => "8.12 Are environmental conditions checked and reviewed accurately?", "description" => "8.12 Are the following environmental conditions checked and recorded daily?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_roomTemp = Question::create(array("section_id" => $sec_sec8->id, "name" => "Room temperature", "title" => "", "description" => "a) Room temperature", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_freezers = Question::create(array("section_id" => $sec_sec8->id, "name" => "Freezers", "title" => "", "description" => "b) Freezers", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_refrigerator = Question::create(array("section_id" => $sec_sec8->id, "name" => "Refrigerator", "title" => "", "description" => "c) Refrigerator", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_incubators = Question::create(array("section_id" => $sec_sec8->id, "name" => "Incubators", "title" => "", "description" => "d) Incubators", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_waterBath = Question::create(array("section_id" => $sec_sec8->id, "name" => "Water Bath", "title" => "", "description" => "e) Water Bath", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_accRanges = Question::create(array("section_id" => $sec_sec8->id, "name" => "Acceptable ranges defined", "title" => "", "description" => "8.13 Have acceptable ranges been defined for all temperature- dependent equipment with procedures and documentation of action taken in response to out of range temperatures?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_interLabComp = Question::create(array("section_id" => $sec_sec8->id, "name" => "Inter-laboratory Comparison programmes", "title" => "", "description" => "8.14 Does the laboratory participate in interlaboratory comparison program or alternative assessment systems for all tests?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_ptProvAccreditted = Question::create(array("section_id" => $sec_sec8->id, "name" => "PT samples come from providers who are accredited", "title" => "", "description" => "a) Do samples come from providers who are accredited or approved?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ptSpecHandledNormally = Question::create(array("section_id" => $sec_sec8->id, "name" => "PT specimens handled normally", "title" => "", "description" => "b) Are specimens handled and tested the same way as patient specimens?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ptProgDisc = Question::create(array("section_id" => $sec_sec8->id, "name" => "PT Program reviewed and discussed", "title" => "", "description" => "c) Is the performance of the laboratory in the PT program reviewed and discussed with relevant staff?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ptResCauseAnalysis = Question::create(array("section_id" => $sec_sec8->id, "name" => "Cause analysis performed for unacceptable PT results", "title" => "", "description" => "d) Is cause analysis performed for unacceptable results?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ptResCorrAct = Question::create(array("section_id" => $sec_sec8->id, "name" => "Corrective action for unacceptable PT results", "title" => "", "description" => "e) Is corrective action documented for unacceptable results?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        //  Section 9 - Information Management
        $question_testResRepSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test Result Reporting System", "title" => "9.1 Test Result Reporting System", "description" => "Are test results legible, technically verified by an authorized person, and confirmed against patient identity?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_testPersonnel = Question::create(array("section_id" => $sec_sec9->id, "name" => "Testing Personnel", "title" => "9.2 Testing Personnel", "description" => "Are testing personnel identified on the result report or other records (manual or electronic)?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_testResRec = Question::create(array("section_id" => $sec_sec9->id, "name" => "Report Content", "title" => "9.3 Report Content", "description" => "Does the laboratory report contain at least the following:", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_testRequested = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test requested", "title" => "", "description" => "a) Test requested", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labIdentification = Question::create(array("section_id" => $sec_sec9->id, "name" => "Identification of the laboratory", "title" => "", "description" => "b) Identification of the laboratory", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_examIdentification = Question::create(array("section_id" => $sec_sec9->id, "name" => "Identification of examinations", "title" => "", "description" => " c) Identification of all examinations performed by a referral laboratory ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_patientIdentification = Question::create(array("section_id" => $sec_sec9->id, "name" => "Identification of Patient", "title" => "", "description" => "d) Patient identification and location ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_nameRequester = Question::create(array("section_id" => $sec_sec9->id, "name" => "Requester Name", "title" => "", "description" => "e) Name of the requester ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_primaryDate = Question::create(array("section_id" => $sec_sec9->id, "name" => "Primary Date", "title" => "", "description" => "f) Date of primary sample collection (and time, relevant to patient care)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_primaryTypeSample = Question::create(array("section_id" => $sec_sec9->id, "name" => "Primary Sample", "title" => "", "description" => "g) Type of primary sample", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_resultReported = Question::create(array("section_id" => $sec_sec9->id, "name" => "Results Reported", "title" => " ", "description" => "h) Is the result reported in SI units where applicable?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_biologicalRefrence= Question::create(array("section_id" => $sec_sec9->id, "name" => "Biological Refrence", "title" => "", "description" => "i) Biological reference intervals where applicable", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_interpretationSpace= Question::create(array("section_id" => $sec_sec9->id, "name" => "interpretation Space", "title" => "", "description" => "j) Is there space for interpretation or comments of results, when applicable?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_authorizingReports= Question::create(array("section_id" => $sec_sec9->id, "name" => "Person Authorizing Reports", "title" => "", "description" => "k) Identification of the person(s) reviewing and authorizing the report", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_dateTime= Question::create(array("section_id" => $sec_sec9->id, "name" => "Date and Time", "title" => "","description"=> "l) Date and time of the report ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_pageNumber= Question::create(array("section_id" => $sec_sec9->id, "name" => "Page Number", "title" => "","description" => "m) Page number to total number of pages (e.g. 'Page 1 of 5', 'Page 2 of 5', etc.) ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_revisedReports= Question::create(array("section_id" => $sec_sec9->id, "name" => "Issuing Revised Reports", "title" => "","description" => " n) When issuing revised reports, is it clearly identified as a revision and includes reference to the date and patient's identity in the original report and the user made aware of the revision?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_revisedReportsDate= Question::create(array("section_id" => $sec_sec9->id, "name" => "Revised Records Show Time and Date", "title" => "","description" => "o) Does the revised record show the time and date of the change and the name of the person responsible for the change?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_OriginalReport= Question::create(array("section_id" => $sec_sec9->id, "name" => "Original Report Entry", "title" => "","description" => "p) Does the original report entry remain in the record when revisions are made?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_analyticSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Analytic System/Method Tracing", "title" => "9.4 Analytic System/Method Tracing", "description" => "When more than one instrument is in use for the same test, are test results traceable to the equipment used for testing?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_arcDataLabel = Question::create(array("section_id" => $sec_sec9->id, "name" => "Archived Data Labeling and Storage", "title" => "9.5 Archived Data Labeling and Storage", "description" => "Are archived results (paper or data-storage media) properly labeled and stored in a secure location accessible only to authorized personnel?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_authoritiesResp = Question::create(array("section_id" => $sec_sec9->id, "name" => "Authorities and Responsibilities", "title" => "9.6 Authorities and Responsibilities ", "description" => "Has the laboratory defined and implemented authorities and responsibilities for the management and use of the laboratory information system– paper based and electronic, including maintenance and modifications that may affect patient care? Is the following in place and implemented?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_controlledAccess = Question::create(array("section_id" => $sec_sec9->id, "name" => "Controlled Access", "title" => "", "description" => "a) Controlled access to patient data and information", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_controlledAccessEnter = Question::create(array("section_id" => $sec_sec9->id, "name" => "Controlled Access to Enter Patient", "title" => "", "description" => "b) Controlled access to enter patient data and examination results ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_controlledAccessChanging = Question::create(array("section_id" => $sec_sec9->id, "name" => "Controlled Access to changing Patient", "title" => "", "description" => "c) Controlled access to changing patient data or examination results ", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_controlledAccessRelease = Question::create(array("section_id" => $sec_sec9->id, "name" => "Controlled Access to Release Patient", "title" => "", "description" => "d) Controlled access to the release of examination results and reports", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_verifyResults = Question::create(array("section_id" => $sec_sec9->id, "name" => "Verification of Results", "title" => "", "description" => "e) Verify that results that have been transmitted electronically or reproduced external to the laboratory (computers, fax machines, email and websites and personal web devices) are correct", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_backupSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Information Management System", "title" => "9.7 Information Management System", "description" => "Does the laboratory have evidence of how the LIMS was selected?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_testResReport = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test Result ", "title" => "9.8 Test Result Report", "description" => "Are test results validated, interpreted and released by appropriately-authorized personnel?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_electronicVerification = Question::create(array("section_id" => $sec_sec9->id, "name" => "Verification of Electronic", "title" => "9.9 Verification of Electronic Laboratory Information System", "description" => "", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_sysVerification = Question::create(array("section_id" => $sec_sec9->id, "name" => "System been verified before implementation", "title" => "", "description" => "a) Has the system been verified before implementation that include the verification reports to check functioning and inter-phasing by the laboratory?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_RecordValidation= Question::create(array("section_id" => $sec_sec9->id, "name" => "Records Validation", "title" => "", "description" => "b) Records of the validation by the supplier available and approved for use?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_systemChecks = Question::create(array("section_id" => $sec_sec9->id, "name" => "Ongoing System Checks", "title" => "", "description" => "c) Ongoing system checks available for correct transmissions, calculations and storage of results and records.", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_labSystemMentained = Question::create(array("section_id" => $sec_sec9->id, "name" => "Laboratory Information System properly maintained", "title" => "9.10 Is the Laboratory Information System properly maintained to ensure continued functioning:", "description" => " ", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_docRegularservice = Question::create(array("section_id" => $sec_sec9->id, "name" => "Documentation Regular Service", "title" => "", "description" => "a) Documented regular service by authorized and trained personnel", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_dcoSystemFailure = Question::create(array("section_id" => $sec_sec9->id, "name" => " Documented System Failure", "title" => "", "description" => "b) Documented system failures with documented appropriate root cause analysis, corrective actions and preventative actions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_operationEnvironment= Question::create(array("section_id" => $sec_sec9->id, "name" => "System Operation Environment", "title" => "", "description" => "c) System operated in an environment recommended by the supplier for optimal functioning", "question_type" => "0", "score" => "0", "user_id" => "1"));
        //  Section 10 - Corerective Action
        $question_nonConfDoc = Question::create(array("section_id" => $sec_sec10->id, "name" => "Non-conforming activities documented", "title" => "10.1 Are all identified nonconforming activities/ work identified and documented adequately?", "description" => "", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_details = Question::create(array("section_id" => $sec_sec10->id, "name" => "Details of what happened", "title" => "", "description" => "a) Indicating details of what happened, when, person responsible.", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_acTaken = Question::create(array("section_id" => $sec_sec10->id, "name" => "Immediate actions being taken", "title" => "", "description" => "b) Immediate actions being taken", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_extent = Question::create(array("section_id" => $sec_sec10->id, "name" => "Determination of the extent of the non- conformity?", "title" => "", "description" => "c) Determination of the extent of the non- conformity?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_halted = Question::create(array("section_id" => $sec_sec10->id, "name" => "Examination halted", "title" => "", "description" => "d) Are examinations halted and results withheld or recalled where the non-conformity compromises patient results?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_inforReq = Question::create(array("section_id" => $sec_sec10->id, "name" => "Inform requester", "title" => "", "description" => "e) Informing the requester where the non -conformity has an effect on the management of the patient", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_authOfRes = Question::create(array("section_id" => $sec_sec10->id, "name" => "Authorization of resumption", "title" => "", "description" => "f) Authorization of resumption of testing documented (where testing has been halted)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_rootCause = Question::create(array("section_id" => $sec_sec10->id, "name" => "Root Cause", "title" => "10.2 Is documented root cause analysis performed for non-conforming work before corrective actions are implemented?", "description" => "", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_nonConfWork = Question::create(array("section_id" => $sec_sec10->id, "name" => "Non-conforming work reviewed", "title" => "10.3 Is corrective action performed and documented for non-conforming work?", "description" => "", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_impCorrAct = Question::create(array("section_id" => $sec_sec10->id, "name" => "Implemented Corrective Actions monitored", "title" => "10.4 Are implemented corrective actions monitored and reviewed for their effectiveness before closure/clearance?", "description" => "", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_prevActs = Question::create(array("section_id" => $sec_sec10->id, "name" => "Documented preventive actions", "title" => "10.5 Preventive Actions", "description" => "Are documented preventive actions implemented and monitored for their effectiveness?", "question_type" => "0", "score" => "5", "user_id" => "1"));
        $question_labDataRev = Question::create(array("section_id" => $sec_sec10->id, "name" => "Lab data review", "title" => "", "description" => "a) Reviewing of laboratory data and information to determine potential non conformities", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_potNonConf = Question::create(array("section_id" => $sec_sec10->id, "name" => "Potential non-conformity", "title" => "", "description" => "b) Determining root causes for potential non conformities", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_docPrevAct = Question::create(array("section_id" => $sec_sec10->id, "name" => "Documenting preventive actions", "title" => "", "description" => "c) Implementing and documenting preventive actions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_effPrevAct = Question::create(array("section_id" => $sec_sec10->id, "name" => "Effectiveness of preventive actions", "title" => "", "description" => "d) Reviewing and documenting effectiveness of preventive actions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        //  Section 11 - Occurence/Incident Management & Process Improvement
        $question_graphTools = Question::create(array("section_id" => $sec_sec11->id, "name" => "Graphical tools (charts and graphs) used", "title" => "11.1 Graphical Tools", "description" => "Are graphical tools (charts and graphs) used to communicate quality findings and identify trends?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_qmsImpMeas = Question::create(array("section_id" => $sec_sec11->id, "name" => "QMS Improvement Measure", "title" => "11.2 Quality Management System Improvement Measures", "description" => "Does the laboratory identify and undertake continual quality improvement projects?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_commSys = Question::create(array("section_id" => $sec_sec11->id, "name" => "Communication System on Lab Operation", "title" => "11.3 Communication System on Laboratory Operations", "description" => "Does the laboratory communicate with upper management regularly regarding needs for continual improvement?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_qIndTracked = Question::create(array("section_id" => $sec_sec11->id, "name" => "Quality indicators selected, tracked, and reviewed", "title" => "11.4 Quality Indicators", "description" => "Are quality indicators (TAT, rejected specimens, stock outs, etc.) selected, tracked, and reviewed regularly to monitor laboratory performance and identify potential quality improvement activities?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labPerfImprove = Question::create(array("section_id" => $sec_sec11->id, "name" => "Quality indicators used to improve lab performance", "title" => "11.5 Lab Performance Improvement", "description" => "Are the outcomes of internal and external audits, PT, customer feedback and all other information derived from the tracking of quality indicators used to improve lab performance?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_effLabPerfImpro = Question::create(array("section_id" => $sec_sec11->id, "name" => "Effectiveness of improved quality of lab performance", "title" => "11.6 Quality of Lab Performance", "description" => "Are the actions taken checked and monitored to determine the effectiveness of improved quality of lab performance?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        //  Section 12 - Facilities and Safety
        $question_sizeOfLab = Question::create(array("section_id" => $sec_sec12->id, "name" => "Size of the laboratory adequate", "title" => "12.1 Size of the Laboratory", "description" => "Is there documented evidence that the laboratory has evaluated the adequacy of the size and overall layout of the laboratory and organized the space so that workstations are positioned for optimal workflow?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_patCareTest = Question::create(array("section_id" => $sec_sec12->id, "name" => "Patient care and testing", "title" => "12.2 Patient care and testing areas", "description" => "Are the patient care and testing areas of the laboratory distinctly separate from one another?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_workstationMan = Question::create(array("section_id" => $sec_sec12->id, "name" => "Individual workstation maintained", "title" => "12.3 Individual workstation maintenance", "description" => "Is each individual workstation maintained free of clutter and set up for efficient operation?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_equipPlacement = Question::create(array("section_id" => $sec_sec12->id, "name" => "Equipment placement", "title" => "", "description" => "a) Does the equipment placement/layout facilitate optimum workflow?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_neededSupplies = Question::create(array("section_id" => $sec_sec12->id, "name" => "Needed supplies present and easily accessible", "title" => "", "description" => "b) Are all needed supplies present and easily accessible?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_chairStool = Question::create(array("section_id" => $sec_sec12->id, "name" => "Stools at the workstations", "title" => "", "description" => "c) Are the chairs/stools at the workstations appropriate for bench height and the testing operations being performed?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_phyWorkEnv = Question::create(array("section_id" => $sec_sec12->id, "name" => "Physical work environment appropriate", "title" => "12.4 Physical work environment", "description" => "Is the physical work environment appropriate for testing?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_freeOfClutter = Question::create(array("section_id" => $sec_sec12->id, "name" => "Free of clutter", "title" => "", "description" => "a) Free of clutter", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_adVent = Question::create(array("section_id" => $sec_sec12->id, "name" => "Adequately ventilated", "title" => "", "description" => "b) Adequately ventilated?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_lit = Question::create(array("section_id" => $sec_sec12->id, "name" => "Adequately lit", "title" => "", "description" => "c) Adequately lit?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_climateCon = Question::create(array("section_id" => $sec_sec12->id, "name" => "Climate-controlled", "title" => "", "description" => "d) Climate-controlled for optimum equipment function?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_filtersChecked = Question::create(array("section_id" => $sec_sec12->id, "name" => "Filters checked", "title" => "", "description" => "e) Are filters checked, cleaned and/or replaced at regular intervals, where air-conditioning is installed?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_wireCables = Question::create(array("section_id" => $sec_sec12->id, "name" => "Wires and cables properly located", "title" => "", "description" => "f) Are wires and cables properly located and protected from traffic?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_generator = Question::create(array("section_id" => $sec_sec12->id, "name" => "Functioning back-up power supply", "title" => "", "description" => "g) Is there a functioning back-up power supply (generator)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_criticalEquip = Question::create(array("section_id" => $sec_sec12->id, "name" => "Critical equipment supported by uninterrupted power", "title" => "", "description" => "h) Is critical equipment supported by uninterrupted power source (UPS) systems?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_waterHazards = Question::create(array("section_id" => $sec_sec12->id, "name" => "Equipment placed away from water hazards", "title" => "", "description" => "i) Is equipment placed appropriately (away from water hazards, out of traffic areas)?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_deionizedWater = Question::create(array("section_id" => $sec_sec12->id, "name" => "Deionized water (DI) or distilled water", "title" => "", "description" => "j) Are appropriate provisions made for adequate water supply, including deionized water (DI) or distilled water, if needed?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_clericalWork = Question::create(array("section_id" => $sec_sec12->id, "name" => "Clerical work completed outside the testing area", "title" => "", "description" => "k) Is clerical work completed outside the testing area?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_majSafetySignage = Question::create(array("section_id" => $sec_sec12->id, "name" => "Major safety signage posted", "title" => "", "description" => "l) Is major safety signage posted and enforced including NO EATING, SMOKING, DRINKING?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_secUnauthorized = Question::create(array("section_id" => $sec_sec12->id, "name" => "Secured from unauthorized access", "title" => "12.5  Laboratory Access", "description" => "Is the laboratory properly secured from unauthorized access with appropriate signage?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_dedColdRoom = Question::create(array("section_id" => $sec_sec12->id, "name" => "Laboratory-dedicated cold and room temperature", "title" => "12.6  Laboratory Storage Areas", "description" => "Is laboratory-dedicated cold and room temperature storage free of staff food items, and are patient samples stored separately from reagents and blood products in the laboratory refrigerators and freezers?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_workAreaClean = Question::create(array("section_id" => $sec_sec12->id, "name" => "Work area clean and free of leakage", "title" => "12.7  Work Area", "description" => "Is the work area clean and free of leakage & spills, and are disinfection procedures conducted and documented?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_bioSafetyCab = Question::create(array("section_id" => $sec_sec12->id, "name" => "Certified and appropriate Biosafety cabinet", "title" => "12.8  Biosafety Cabinet", "description" => "Is a certified and appropriate Biosafety cabinet (or an acceptable alternative processing procedure) in use for all specimens or organisms considered to be highly contagious by airborne routes? (Biosafety cabinet should be recertified according to national protocol).", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labSafetyManual = Question::create(array("section_id" => $sec_sec12->id, "name" => "Laboratory safety manual available", "title" => "12.9 Laboratory Safety Manual", "description" => "Is a laboratory safety manual available, accessible, and up-to-date? Does the safety manual include guidelines on the following topics?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_bloboPre = Question::create(array("section_id" => $sec_sec12->id, "name" => "Blood and Body Fluid Precautions", "title" => "", "description" => "a) Blood and Body Fluid Precautions", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_hazardWasteDisp = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous Waste Disposal", "title" => "", "description" => "b) Hazardous Waste Disposal", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_hazardChem = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous Chemicals", "title" => "", "description" => "c) Hazardous Chemicals / Materials", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_msds = Question::create(array("section_id" => $sec_sec12->id, "name" => "MSDS Sheets", "title" => "", "description" => "d) MSDS Sheets", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_persProEquip = Question::create(array("section_id" => $sec_sec12->id, "name" => "Personal protective equipment", "title" => "", "description" => "e) Personal protective equipment", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_vaccination = Question::create(array("section_id" => $sec_sec12->id, "name" => "Vaccination", "title" => "", "description" => "f) Vaccination", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_prophylaxis = Question::create(array("section_id" => $sec_sec12->id, "name" => "Post-Exposure Prophylaxis", "title" => "", "description" => "g) Post-Exposure Prophylaxis", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_fireSafety = Question::create(array("section_id" => $sec_sec12->id, "name" => "Fire Safety", "title" => "", "description" => "h) Fire Safety", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_elecSafety = Question::create(array("section_id" => $sec_sec12->id, "name" => "Electrical safety", "title" => "", "description" => "i) Electrical safety", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_suffWasteDisp = Question::create(array("section_id" => $sec_sec12->id, "name" => "Sufficient waste disposal available", "title" => "12.10  Waste Disposal", "description" => "Is sufficient waste disposal available and is waste separated into infectious and non-infectious waste, with infectious waste autoclaved, incinerated, or buried?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_hazardMaterials = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous materials properly handled", "title" => "12.11  Hazardous Chemicals", "description" => "Are hazardous chemicals / materials properly handled?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_hazardChemLabeled = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly labeled", "title" => "", "description" => "a) Are hazardous chemicals properly labeled?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_hazardChemStored = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly stored", "title" => "", "description" => "b) Are hazardous chemicals properly stored?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_hazardChemUtilized = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly utilized", "title" => "", "description" => "c) Are hazardous chemicals properly utilized?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_hazardChemDisposed = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly disposed", "title" => "", "description" => "d) Are hazardous chemicals properly disposed?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_sharpsHandled = Question::create(array("section_id" => $sec_sec12->id, "name" => "Sharp containers handled", "title" => "12.12   Handling of Sharps", "description" => "Are 'sharps' handled and disposed of properly in 'sharps' containers that are appropriately utilized?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_overallSafety = Question::create(array("section_id" => $sec_sec12->id, "name" => "Overall safety program", "title" => "12.13  Fire Safety", "description" => "Is fire safety included as part of the laboratory’s overall safety program?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_elecCords = Question::create(array("section_id" => $sec_sec12->id, "name" => "All electricals in good repair", "title" => "", "description" => "a) Are all electrical cords, plugs, and receptacles used appropriately and in good repair?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_extinguisher = Question::create(array("section_id" => $sec_sec12->id, "name" => "Appropriate fire extinguisher available", "title" => "", "description" => "b) Is an appropriate fire extinguisher available, properly placed, in working condition, and routinely inspected?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_fireWarning = Question::create(array("section_id" => $sec_sec12->id, "name" => "Operational fire warning system", "title" => "", "description" => "c) Is an operational fire warning system in place?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_fireDrills = Question::create(array("section_id" => $sec_sec12->id, "name" => "Periodic Fire Drills", "title" => "", "description" => "d) Are periodic fire drills conducted at defined period of time?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_safetyInspec = Question::create(array("section_id" => $sec_sec12->id, "name" => "Safety audits", "title" => "12.14  Safety Audits", "description" => "Are safety inspections or audits conducted regularly and documented?", "question_type" => "0", "score" => "3", "user_id" => "1"));
        $question_safetyPlan = Question::create(array("section_id" => $sec_sec12->id, "name" => "Lab Safety Plan", "title" => "", "description" => "a) Is there an audit plan/schedule that ensures all activities of the lab are checked for safety compliance?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_authInsp = Question::create(array("section_id" => $sec_sec12->id, "name" => "Authorized Inspection", "title" => "", "description" => "b) Are inspections/audits being carried out by authorized persons?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_safetyTrained = Question::create(array("section_id" => $sec_sec12->id, "name" => "Training in safety", "title" => "", "description" => "c) Are the personnel conducting the internal audits trained in safety?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_deficiencies = Question::create(array("section_id" => $sec_sec12->id, "name" => "Noted Deficiencies", "title" => "", "description" => "d) Is cause analysis and action taken for nonconformities/noted deficiencies?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_safetyFind = Question::create(array("section_id" => $sec_sec12->id, "name" => "Safety Findings", "title" => "", "description" => "e) Are safety findings documented and presented to the laboratory management and relevant staff for review?", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_stdSafetyEquip = Question::create(array("section_id" => $sec_sec12->id, "name" => "Standard safety equipment available", "title" => "12.15   Safety Equipment", "description" => "Is standard safety equipment available and in use in the laboratory?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_bioSafetyCabinets = Question::create(array("section_id" => $sec_sec12->id, "name" => "Biosafety cabinet", "title" => "", "description" => "a) Biosafety cabinet(s)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_centrifuge = Question::create(array("section_id" => $sec_sec12->id, "name" => "Covers on centrifuge", "title" => "", "description" => "b) Covers on centrifuge(s)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_handwash = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hand-washing station", "title" => "", "description" => "c) Hand-washing station", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_eyewash = Question::create(array("section_id" => $sec_sec12->id, "name" => "Eyewash station/bottle", "title" => "", "description" => "d) Eyewash station/bottle(s) and showers where applicable", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_spillKit = Question::create(array("section_id" => $sec_sec12->id, "name" => "Spill kit", "title" => "", "description" => "e) Spill kit(s)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_firstAid = Question::create(array("section_id" => $sec_sec12->id, "name" => "First aid kit", "title" => "", "description" => "f) First aid kit(s)", "question_type" => "0", "score" => "0", "user_id" => "1"));
        $question_ppe = Question::create(array("section_id" => $sec_sec12->id, "name" => "Personal protective equipment", "title" => "12.16 Personnel Protective Equipment", "description" => "Is personal protective equipment (PPE) easily accessible at the workstation and utilized appropriately and consistently?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_labPersVacc = Question::create(array("section_id" => $sec_sec12->id, "name" => "Vaccination/preventive measures", "title" => "12.17 Staff Vaccinations", "description" => "Are laboratory personnel offered appropriate vaccination/preventive measures?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_prophyPoSops = Question::create(array("section_id" => $sec_sec12->id, "name" => "Post-exposure prophylaxis policies and procedures", "title" => "12.18 Post Exposure Prophylaxis", "description" => "Are post-exposure prophylaxis policies and procedures posted and implemented after possible and known exposures?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_injuriesLog = Question::create(array("section_id" => $sec_sec12->id, "name" => "Occupational injuries Log", "title" => "12.19 Adverse incidents", "description" => "Are adverse incidents or injuries from equipment, reagents, occupational injuries, medical screening or illnesses, documented and investigated?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_workerBioTrained = Question::create(array("section_id" => $sec_sec12->id, "name" => "Laboratory workers trained in Biosafety", "title" => "12.20 Biosafety Training", "description" => "Are drivers/couriers and cleaners working with the laboratory trained in Biosafety practices relevant to their job tasks?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $question_safetyOfficer = Question::create(array("section_id" => $sec_sec12->id, "name" => "Trained safety officer designated to implement and monitor the safety program ", "title" => "12.21 Laboratory Safety Officer", "description" => "Is a trained safety officer designated to implement and monitor the safety program in the laboratory, including the training of other staff?", "question_type" => "0", "score" => "2", "user_id" => "1"));
        $this->command->info('Questions table seeded');

        /* Question-Notes */
        // Section 1
        DB::table('question_notes')->insert(
            array("question_id" => $question_legalEntity->id, "note_id" => $note_legalEn->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labQManual->id, "note_id" => $note_labQM->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docInfoCon->id, "note_id" => $note_docInfoControl->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docRecords->id, "note_id" => $note_docRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_poSops->id, "note_id" => $note_poSops->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_sopsEthCon->id, "note_id" => $note_ethCon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docRecControl->id, "note_id" => $note_docuCon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_recControl->id, "note_id" => $note_contRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_communication->id, "note_id" => $note_intExtComm->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_servAgr->id, "note_id" => $note_servAgr->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_referralExam->id, "note_id" => $note_reffLabs->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_extSerSupp->id, "note_id" => $note_exServSupp->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_purInvCon->id, "note_id" => $note_purInvCon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_advisory->id, "note_id" => $note_adServ->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_compFeedback->id, "note_id" => $note_resCompFeed->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_nonConformities->id, "note_id" => $note_nc->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_corrAction->id, "note_id" => $note_corAct->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_prevAction->id, "note_id" => $note_prevAct->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_contImpro->id, "note_id" => $note_conImp->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_conRec->id, "note_id" => $note_conRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_inAudits->id, "note_id" => $note_inAud->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_riskMan->id, "note_id" => $note_riskMan->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_manReview->id, "note_id" => $note_manRev->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_persMan->id, "note_id" => $note_perMan->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_persTraining->id, "note_id" => $note_perTra->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_competencyAudit->id, "note_id" => $note_compAssess->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_Auth->id, "note_id" => $note_auth->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_revStaPerf->id, "note_id" => $note_staPerf->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_Accomo->id, "note_id" => $note_envCon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_Equip->id, "note_id" => $note_labEquip->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_EquiCalib->id, "note_id" => $note_calEquip->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_preExamPro->id, "note_id" => $note_preExPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_valVer->id, "note_id" => $note_valVer->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_meUnc->id, "note_id" => $note_meUnc->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_bioRef->id, "note_id" => $note_bioRef->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docExPro->id, "note_id" => $note_docExPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labContPro->id, "note_id" => $note_labContPlan->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_QCQA->id, "note_id" => $note_quaCon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_repRelRes->id, "note_id" => $note_repRes->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_lis->id, "note_id" => $note_lis->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labSafeMan->id, "note_id" => $note_labSaMan->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_poSopsA->id, "note_id" => $note_poSopsAcc->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_poSopsComm->id, "note_id" => $note_poSopsComm->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docConLog->id, "note_id" => $note_docContLog->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_discPoSops->id, "note_id" => $note_discPoSops->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_dataFiles->id, "note_id" => $note_dataFiles->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_arcResA->id, "note_id" => $note_arcRes->id));
        //  Section 2
        DB::table('question_notes')->insert(
            array("question_id" => $question_quaTechRecRev->id, "note_id" => $note_quaTecRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_manRev->id, "note_id" => $note_revOut->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_mrComm->id, "note_id" => $note_mrComm->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_mrComp->id, "note_id" => $note_mrComp->id));
        //  Section 3
        DB::table('question_notes')->insert(
            array("question_id" => $question_duRoDaRo->id, "note_id" => $note_duRoDa->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_orgChart->id, "note_id" => $note_orgChart->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labDir->id, "note_id" => $note_labDir->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_qmsOversight->id, "note_id" => $note_qmsOversight->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_perFilSys->id, "note_id" => $note_perFiSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labStaffTra->id, "note_id" => $note_labStaffTra->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_staffCompAudit->id, "note_id" => $note_staffCompetency->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_staffMeet->id, "note_id" => $note_staffMeet->id));
        //  Section 4
        DB::table('question_notes')->insert(
            array("question_id" => $question_advTraQS->id, "note_id" => $note_adviceTra->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_resOfComp->id, "note_id" => $note_resComp->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labHandbook->id, "note_id" => $note_labHandbook->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_commPoOnDelays->id, "note_id" => $note_commOnDelays->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_evalTool->id, "note_id" => $note_evalTool->id));
        //  Section 5
        DB::table('question_notes')->insert(
            array("question_id" => $question_properEquiPro->id, "note_id" => $note_properEquip->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipOper->id, "note_id" => $note_equiOper->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipMethVal->id, "note_id" => $note_equipMethVal->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_meQuaTests->id, "note_id" => $note_meQuaTests->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipRecMan->id, "note_id" => $note_equipRecMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipManRec->id, "note_id" => $note_equipManRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_defEquip->id, "note_id" => $note_defEquip->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_obsoEquipPro->id, "note_id" => $note_obsoEquiPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipCalibPro->id, "note_id" => $note_equipCalibPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipPrevMan->id, "note_id" => $note_equipPreMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipSerMan->id, "note_id" => $note_equipSerMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipMalf->id, "note_id" => $note_equipMalf->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipRepMon->id, "note_id" => $note_equipRepair->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipFailPlan->id, "note_id" => $note_equipFailure->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_manManual->id, "note_id" => $note_manOpManual->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labTestSer->id, "note_id" => $note_labTests->id));
        //  Section 6
        DB::table('question_notes')->insert(
            array("question_id" => $question_internalAudits->id, "note_id" => $note_internalAudits->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_auditRecomm->id, "note_id" => $note_audRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_riskManage->id, "note_id" => $note_riskManage->id));
        //  Section 7
        DB::table('question_notes')->insert(
            array("question_id" => $question_invBudget->id, "note_id" => $note_invBudgetSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_specForSupp->id, "note_id" => $note_suppSpec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "note_id" => $note_suppPerfRev->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_invCon->id, "note_id" => $note_invCont->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_budgetaryPro->id, "note_id" => $note_budgetPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_manRevSuppReq->id, "note_id" => $note_manRevSuppReq->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labInvSys->id, "note_id" => $note_labInvSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_storageArea->id, "note_id" => $note_stoArea->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_wastageMin->id, "note_id" => $note_invOrg->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_dispExProd->id, "note_id" => $note_disExPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_prodExpiration->id, "note_id" => $note_proEx->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labTestServices->id, "note_id" => $note_labTestServ->id));
        //  Section 8
        DB::table('question_notes')->insert(
            array("question_id" => $question_patIdGuide->id, "note_id" => $note_info4pat->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_adSampInfo->id, "note_id" => $note_adeqInfo->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_sampRecPro->id, "note_id" => $note_adeqSamp->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_preExHand->id, "note_id" => $note_preExHand->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_sampTrans->id, "note_id" => $note_sampTrans->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_evalRefLabs->id, "note_id" => $note_evalRefLabs->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docExProc->id, "note_id" => $note_docExProc->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_reAcc->id, "note_id" => $note_reAccTest->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_quaCon->id, "note_id" => $note_qualityCon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_quaConData->id, "note_id" => $note_qualityConData->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_compExRes->id, "note_id" => $note_compaExRes->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_envCondCheck->id, "note_id" => $note_envConCheck->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_accRanges->id, "note_id" => $note_accRanges->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_interLabComp->id, "note_id" => $note_interLab->id));
        //  Section 9
        DB::table('question_notes')->insert(
            array("question_id" => $question_testResRepSys->id, "note_id" => $note_testResRep->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testPersonnel->id, "note_id" => $note_testPersonnel->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testResRec->id, "note_id" => $note_repCont->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_analyticSys->id, "note_id" => $note_analyticSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_arcDataLabel->id, "note_id" => $note_arcDataLab->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_authoritiesResp->id, "note_id" => $note_authResp->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_backupSys->id, "note_id" => $note_infoManSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testResReport->id, "note_id" => $note_testRes->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_sysVerification->id, "note_id" => $note_lisVer->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labSystemMentained->id, "note_id" => $note_lisMan->id));
        //  Section 10
        DB::table('question_notes')->insert(
            array("question_id" => $question_nonConfDoc->id, "note_id" => $note_nonConf->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_rootCause->id, "note_id" => $note_rootCause->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_nonConfWork->id, "note_id" => $note_corrActPerf->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_impCorrAct->id, "note_id" => $note_corrActMon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_prevActs->id, "note_id" => $note_prevActions->id));
        //  Section 11
        DB::table('question_notes')->insert(
            array("question_id" => $question_graphTools->id, "note_id" => $note_graphTools->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_qmsImpMeas->id, "note_id" => $note_quaManSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_commSys->id, "note_id" => $note_commSysLab->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_qIndTracked->id, "note_id" => $note_qIndicators->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labPerfImprove->id, "note_id" => $note_outOfRev->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_effLabPerfImpro->id, "note_id" => $note_actCheckMon->id));
        //  Section 12
        DB::table('question_notes')->insert(
            array("question_id" => $question_sizeOfLab->id, "note_id" => $note_sizeOfLab->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_patCareTest->id, "note_id" => $note_careNTesting->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_workstationMan->id, "note_id" => $note_workStaMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_phyWorkEnv->id, "note_id" => $note_phyWorkEnv->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_secUnauthorized->id, "note_id" => $note_labSecured->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_dedColdRoom->id, "note_id" => $note_labDedColdRoom->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_workAreaClean->id, "note_id" => $note_leakageSpills->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_bioSafetyCab->id, "note_id" => $note_certBiosafetyCab->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labSafetyManual->id, "note_id" => $note_labSafetyManual->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_suffWasteDisp->id, "note_id" => $note_suffWasteDisposal->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_hazardMaterials->id, "note_id" => $note_hazardousChem->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_sharpsHandled->id, "note_id" => $note_sharpsDisposed->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_overallSafety->id, "note_id" => $note_fireSafety->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_safetyInspec->id, "note_id" => $note_inspAudReg->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_stdSafetyEquip->id, "note_id" => $note_stdSafetyEqui->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_ppe->id, "note_id" => $note_personalProEqui->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labPersVacc->id, "note_id" => $note_vaccPrevMeasures->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_prophyPoSops->id, "note_id" => $note_postExProphy->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_injuriesLog->id, "note_id" => $note_occInjuries->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_workerBioTrained->id, "note_id" => $note_workersTraBiosafety->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_safetyOfficer->id, "note_id" => $note_trainedSafetyOfficer->id));
        $this->command->info('Question-notes table seeded');

        /* Question-Answers */
        //  Section 1
        DB::table('question_answers')->insert(
            array("question_id" => $question_legalEntity->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_legalEntity->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_legalEntity->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQPolicy->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQPolicy->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQPolicy->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQMS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQMS->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQMS->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQStructure->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQStructure->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQStructure->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSProcedures->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSProcedures->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSProcedures->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labRoles->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labRoles->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labRoles->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDocManReview->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDocManReview->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDocManReview->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPers->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPers->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPers->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docInfoCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docInfoCon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docInfoCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecords->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecords->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecords->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sopsEthCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sopsEthCon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sopsEthCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecControl->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecControl->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecControl->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recControl->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recControl->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recControl->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_communication->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_communication->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_communication->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_servAgr->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_servAgr->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_servAgr->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referralExam->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referralExam->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referralExam->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extSerSupp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extSerSupp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extSerSupp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_purInvCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_purInvCon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_purInvCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advisory->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advisory->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advisory->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compFeedback->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compFeedback->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compFeedback->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConformities->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConformities->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConformities->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAction->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAction->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAction->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevAction->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevAction->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevAction->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImpro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImpro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImpro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_conRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_conRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_conRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudits->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudits->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudits->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_riskMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_riskMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_riskMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manReview->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manReview->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manReview->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persTraining->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persTraining->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persTraining->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_competencyAudit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_competencyAudit->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_competencyAudit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Auth->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Auth->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Auth->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaffPerf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaffPerf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaffPerf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Accomo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Accomo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Accomo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Equip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Equip->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Equip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_EquiCalib->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_EquiCalib->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_EquiCalib->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExamPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExamPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExamPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_meUnc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_meUnc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_meUnc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRef->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRef->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRef->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docExPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docExPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docExPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labContPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labContPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labContPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_QCQA->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_QCQA->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_QCQA->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repRelRes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repRelRes->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repRelRes->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lis->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSafeMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSafeMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSafeMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSopsA->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSopsA->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSopsA->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSopsComm->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSopsComm->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSopsComm->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docConLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docConLog->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docConLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discPoSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discPoSops->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discPoSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataFiles->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataFiles->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataFiles->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcResA->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcResA->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcResA->id, "answer_id" => $answer_no->id));
        //  Section 2
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevActItems->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevActItems->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevActItems->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrActStatus->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrActStatus->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrActStatus->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repFromPersonnel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repFromPersonnel->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repFromPersonnel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_envMonLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_envMonLog->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_envMonLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speRejLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speRejLog->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speRejLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiCalibManRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiCalibManRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiCalibManRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_iqcRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_iqcRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_iqcRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptIntLabCo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptIntLabCo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptIntLabCo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qInd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qInd->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qInd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_custCompFeed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_custCompFeed->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_custCompFeed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impProRes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impProRes->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impProRes->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revActPlanDoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revActPlanDoc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revActPlanDoc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perRev->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perRev->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perRev->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_feedAssess->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_feedAssess->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_feedAssess->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffSugg->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffSugg->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffSugg->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAud->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAud->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAud->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_rskMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_rskMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_rskMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaInd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaInd->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaInd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extAssess->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extAssess->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extAssess->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interLab->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interLab->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interLab->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_monResConf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_monResConf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_monResConf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suppPerf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suppPerf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suppPerf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_idConNon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_idConNon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_idConNon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_followUp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_followUp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_followUp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_volScope->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_volScope->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_volScope->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recForImpro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recForImpro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recForImpro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaObQuaPo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaObQuaPo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaObQuaPo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOutRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOutRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOutRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrMeet->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrMeet->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrMeet->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repAddRes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repAddRes->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repAddRes->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refToImpro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refToImpro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refToImpro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effQuaSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effQuaSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effQuaSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaAppro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaAppro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaAppro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrComm->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrComm->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrComm->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrComp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrComp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_mrComp->id, "answer_id" => $answer_no->id));
        //  Section 3
        DB::table('question_answers')->insert(
            array("question_id" => $question_duRoDaRo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_duRoDaRo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_duRoDaRo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_orgChart->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_orgChart->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_orgChart->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effLead->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effLead->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effLead->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_stakeComm->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_stakeComm->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_stakeComm->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adCompSta->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adCompSta->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adCompSta->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsImp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsImp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsImp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSuppMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSuppMon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSuppMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabMon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabMon->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safeLabEnv->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safeLabEnv->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safeLabEnv->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advSer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advSer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advSer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_profDevProg->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_profDevProg->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_profDevProg->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_addCompReq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_addCompReq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_addCompReq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contPlan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contPlan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contPlan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDesc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDesc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDesc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsProcess->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsProcess->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsProcess->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmReport->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmReport->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmReport->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmPromo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmPromo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmPromo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmPart->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmPart->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmPart->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_edProfQua->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_edProfQua->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_edProfQua->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_edProfQua->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certOrLic->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certOrLic->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certOrLic->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certOrLic->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_CV->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_CV->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_CV->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_CV->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDescr->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDescr->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDescr->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_jobDescr->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newStaIntro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newStaIntro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newStaIntro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newStaIntro->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currJob->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currJob->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currJob->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currJob->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compeAssess->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compeAssess->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compeAssess->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compeAssess->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recContEd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recContEd->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recContEd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recContEd->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaPerf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaPerf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaPerf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revStaPerf->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOfAcc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOfAcc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOfAcc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOfAcc->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_immuSta->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_immuSta->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_immuSta->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_immuSta->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empLetter->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empLetter->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empLetter->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empLetter->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_medSurvRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_medSurvRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_medSurvRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_medSurvRec->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qms->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qms->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qms->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_assWork->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_assWork->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_assWork->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_appLis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_appLis->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_appLis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_appLis->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_healthSafety->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_healthSafety->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_healthSafety->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labEth->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labEth->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labEth->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_confPatInfo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_confPatInfo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_confPatInfo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_supTra->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_supTra->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_supTra->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contMedEd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contMedEd->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contMedEd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_trainPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_trainPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_trainPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defCrit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defCrit->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defCrit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newHire->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newHire->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_newHire->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_existSta->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_existSta->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_existSta->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reTrareAss->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reTrareAss->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reTrareAss->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevStaMeet->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevStaMeet->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevStaMeet->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysRecPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysRecPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysRecPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_complaints->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_complaints->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_complaints->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commOnSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commOnSops->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commOnSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_priorCorrAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_priorCorrAct->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_priorCorrAct->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_evalOfImpro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_evalOfImpro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_evalOfImpro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hospMeetFeed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hospMeetFeed->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hospMeetFeed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relOfRep->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relOfRep->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relOfRep->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recMonMeetNotes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recMonMeetNotes->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recMonMeetNotes->id, "answer_id" => $answer_no->id));
        //  Section 4
        DB::table('question_answers')->insert(
            array("question_id" => $question_advTraQS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advTraQS->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advTraQS->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resOfComp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resOfComp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resOfComp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labHandbook->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labHandbook->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labHandbook->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commPoOnDelays->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commPoOnDelays->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commPoOnDelays->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_evalTool->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_evalTool->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_evalTool->id, "answer_id" => $answer_no->id));
        //  Section 5
        DB::table('question_answers')->insert(
            array("question_id" => $question_properEquiPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_properEquiPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_properEquiPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipOper->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipOper->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipOper->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specValVerPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specValVerPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specValVerPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specValVerPro->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valPerf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valPerf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valPerf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valPerf->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valInfo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valInfo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valInfo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valInfo->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfCharac->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfCharac->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfCharac->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfCharac->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adeqValVer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adeqValVer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adeqValVer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adeqValVer->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataAn->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataAn->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataAn->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dataAn->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVerRep->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVerRep->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVerRep->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_valVerRep->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quantitative->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quantitative->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quantitative->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quantitative->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defPerfReq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defPerfReq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defPerfReq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defPerfReq->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_calMeasure->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_calMeasure->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_calMeasure->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_calMeasure->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipName->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipName->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipName->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manfCont->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manfCont->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manfCont->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_condReceived->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_condReceived->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_condReceived->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serialNo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serialNo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serialNo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateOfPur->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateOfPur->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateOfPur->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_outOfSer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_outOfSer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_outOfSer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateSerEntry->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateSerEntry->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateSerEntry->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_location->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_location->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_location->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceContInf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceContInf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceContInf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceProCont->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceProCont->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceProCont->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_decontaRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_decontaRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_decontaRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevManRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevManRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevManRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lastSerDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lastSerDate->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lastSerDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nextSerDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nextSerDate->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nextSerDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defEquip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defEquip->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_defEquip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_obsoEquipPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_obsoEquipPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_obsoEquipPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_routineCalib->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_routineCalib->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_routineCalib->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_traceCalib->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_traceCalib->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_traceCalib->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reviewCalib->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reviewCalib->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reviewCalib->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certRefMat->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certRefMat->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_certRefMat->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPrevMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPrevMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPrevMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipSerMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipSerMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipSerMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMalf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMalf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMalf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOrders->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOrders->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repOrders->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verDocEquip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verDocEquip->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verDocEquip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipFailPlan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipFailPlan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipFailPlan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manManual->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manManual->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manManual->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestSer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestSer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestSer->id, "answer_id" => $answer_no->id));
        //  Section 6
        DB::table('question_answers')->insert(
            array("question_id" => $question_allQMS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_allQMS->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_allQMS->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_minConfOfIntr->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_minConfOfIntr->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_minConfOfIntr->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_audPers->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_audPers->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_audPers->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_causeAnalPerf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_causeAnalPerf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_causeAnalPerf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudFind->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudFind->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudFind->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_audRepGen->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_audRepGen->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_audRepGen->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrPrevAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrPrevAct->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrPrevAct->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_timeframe->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_timeframe->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_timeframe->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_assessPitfalls->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_assessPitfalls->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_assessPitfalls->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_redPitfalls->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_redPitfalls->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_redPitfalls->id, "answer_id" => $answer_no->id));
        //  Section 7
        DB::table('question_answers')->insert(
            array("question_id" => $question_invBudget->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invBudget->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invBudget->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specForSupp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specForSupp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specForSupp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reaCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reaCon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reaCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_batchLot->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_batchLot->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_batchLot->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manSuppName->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manSuppName->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manSuppName->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_receiptDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_receiptDate->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_receiptDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manPack->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manPack->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manPack->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inspRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inspRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inspRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_budgetaryPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_budgetaryPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_budgetaryPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manRevSuppReq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manRevSuppReq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manRevSuppReq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invRecComp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invRecComp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invRecComp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consRate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consRate->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consRate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_stockCounts->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_stockCounts->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_stockCounts->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageWellOrg->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageWellOrg->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageWellOrg->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_desigPlaces->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_desigPlaces->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_desigPlaces->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_coldStorage->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_coldStorage->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_coldStorage->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageAreaMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageAreaMon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageAreaMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ambientTemp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ambientTemp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ambientTemp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_directSunlight->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_directSunlight->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_directSunlight->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adequateVent->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adequateVent->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adequateVent->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cleanDustPests->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cleanDustPests->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cleanDustPests->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accessControl->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accessControl->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accessControl->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wastageMin->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wastageMin->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wastageMin->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dispExProd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dispExProd->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dispExProd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prodExpiration->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prodExpiration->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prodExpiration->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestServices->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestServices->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestServices->id, "answer_id" => $answer_no->id));
        //  Section 8
        DB::table('question_answers')->insert(
            array("question_id" => $question_patIdGuide->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patIdGuide->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patIdGuide->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testReqForm->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testReqForm->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testReqForm->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptId->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptId->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptId->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authReq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authReq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authReq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exam->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exam->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exam->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relInfo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relInfo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relInfo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_collDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_collDate->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_collDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_receiptTime->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_receiptTime->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_receiptTime->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consent->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consent->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consent->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consent->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patUniq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patUniq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patUniq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRejCrit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRejCrit->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRejCrit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLog->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verbalReq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verbalReq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verbalReq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_splitSamp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_splitSamp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_splitSamp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_24hour->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_24hour->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_24hour->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrWorksta->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrWorksta->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrWorksta->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExHand->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExHand->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExHand->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sampTrans->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sampTrans->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sampTrans->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabCons->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabCons->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabCons->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabCons->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabRej->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabRej->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabRej->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabRej->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refSpec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refSpec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refSpec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refSpec->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docExProc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docExProc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docExProc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reAcc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reAcc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reAcc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaCon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAcDoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAcDoc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAcDoc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resEval->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resEval->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resEval->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_diffProc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_diffProc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_diffProc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_diffProc->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compStud->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compStud->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compStud->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compStud->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterBath->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterBath->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterBath->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterBath->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRanges->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRanges->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRanges->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProgDisc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProgDisc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProgDisc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCorrAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCorrAct->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCorrAct->id, "answer_id" => $answer_no->id));
        //  Section 9
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResRepSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResRepSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResRepSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testPersonnel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testPersonnel->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testPersonnel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testRequested->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testRequested->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testRequested->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testRequested->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labIdentification->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labIdentification->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labIdentification->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labIdentification->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_examIdentification->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_examIdentification->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_examIdentification->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_examIdentification->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patientIdentification->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patientIdentification->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patientIdentification->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patientIdentification->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nameRequester->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nameRequester->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nameRequester->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nameRequester->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryDate->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryDate->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryTypeSample->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryTypeSample->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryTypeSample->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_primaryTypeSample->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resultReported->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resultReported->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resultReported->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resultReported->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_biologicalRefrence->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_biologicalRefrence->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_biologicalRefrence->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_biologicalRefrence->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interpretationSpace->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interpretationSpace->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interpretationSpace->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interpretationSpace->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authorizingReports->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authorizingReports->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authorizingReports->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authorizingReports->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateTime->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateTime->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateTime->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateTime->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_pageNumber->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_pageNumber->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_pageNumber->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_pageNumber->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReports->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReports->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReports->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReports->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReportsDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReportsDate->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReportsDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revisedReportsDate->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_OriginalReport->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_OriginalReport->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_OriginalReport->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_OriginalReport->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcDataLabel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcDataLabel->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcDataLabel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccess->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccess->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccess->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccess->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessEnter->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessEnter->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessEnter->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessEnter->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessChanging->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessChanging->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessChanging->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessChanging->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessRelease->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessRelease->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessRelease->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_controlledAccessRelease->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verifyResults->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verifyResults->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verifyResults->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_verifyResults->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResReport->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResReport->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResReport->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResReport->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysVerification->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysVerification->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysVerification->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sysVerification->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_RecordValidation->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_RecordValidation->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_RecordValidation->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_RecordValidation->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systemChecks->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systemChecks->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systemChecks->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systemChecks->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRegularservice->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRegularservice->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRegularservice->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRegularservice->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dcoSystemFailure->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dcoSystemFailure->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dcoSystemFailure->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dcoSystemFailure->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_operationEnvironment->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_operationEnvironment->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_operationEnvironment->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_operationEnvironment->id, "answer_id" => $answer_na->id));
        //  Section 10
        DB::table('question_answers')->insert(
            array("question_id" => $question_details->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_details->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_details->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_acTaken->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_acTaken->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_acTaken->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extent->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extent->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extent->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_halted->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_halted->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_halted->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inforReq->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inforReq->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inforReq->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authOfRes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authOfRes->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authOfRes->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_rootCause->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_rootCause->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_rootCause->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConfWork->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConfWork->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConfWork->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impCorrAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impCorrAct->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impCorrAct->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDataRev->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDataRev->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDataRev->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_potNonConf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_potNonConf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_potNonConf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docPrevAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docPrevAct->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docPrevAct->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effPrevAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effPrevAct->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effPrevAct->id, "answer_id" => $answer_no->id));
        //  Section 11
        DB::table('question_answers')->insert(
            array("question_id" => $question_graphTools->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_graphTools->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_graphTools->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsImpMeas->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsImpMeas->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsImpMeas->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qIndTracked->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qIndTracked->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qIndTracked->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPerfImprove->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPerfImprove->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPerfImprove->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effLabPerfImpro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effLabPerfImpro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effLabPerfImpro->id, "answer_id" => $answer_no->id));
        //  Section 12
        DB::table('question_answers')->insert(
            array("question_id" => $question_sizeOfLab->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sizeOfLab->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sizeOfLab->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patCareTest->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patCareTest->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patCareTest->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPlacement->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPlacement->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPlacement->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_neededSupplies->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_neededSupplies->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_neededSupplies->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_chairStool->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_chairStool->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_chairStool->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freeOfClutter->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freeOfClutter->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freeOfClutter->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adVent->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adVent->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adVent->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lit->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_climateCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_climateCon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_climateCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_filtersChecked->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_filtersChecked->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_filtersChecked->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wireCables->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wireCables->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wireCables->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_generator->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_generator->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_generator->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_criticalEquip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_criticalEquip->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_criticalEquip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterHazards->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterHazards->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterHazards->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deionizedWater->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deionizedWater->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deionizedWater->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_clericalWork->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_clericalWork->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_clericalWork->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_majSafetySignage->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_majSafetySignage->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_majSafetySignage->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_secUnauthorized->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_secUnauthorized->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_secUnauthorized->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dedColdRoom->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dedColdRoom->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dedColdRoom->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workAreaClean->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workAreaClean->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workAreaClean->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCab->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCab->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCab->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bloboPre->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bloboPre->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bloboPre->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChem->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChem->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChem->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_msds->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_msds->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_msds->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persProEquip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persProEquip->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persProEquip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_vaccination->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_vaccination->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_vaccination->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophylaxis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophylaxis->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophylaxis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireSafety->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireSafety->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireSafety->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecSafety->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecSafety->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecSafety->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suffWasteDisp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suffWasteDisp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suffWasteDisp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemStored->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemStored->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemStored->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sharpsHandled->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sharpsHandled->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sharpsHandled->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecCords->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecCords->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecCords->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extinguisher->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extinguisher->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extinguisher->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireWarning->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireWarning->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireWarning->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireDrills->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireDrills->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireDrills->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyPlan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyPlan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyPlan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authInsp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authInsp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authInsp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyTrained->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyTrained->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyTrained->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deficiencies->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deficiencies->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deficiencies->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyFind->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyFind->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyFind->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_centrifuge->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_centrifuge->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_centrifuge->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_handwash->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_handwash->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_handwash->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_eyewash->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_eyewash->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_eyewash->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_spillKit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_spillKit->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_spillKit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_firstAid->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_firstAid->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_firstAid->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ppe->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ppe->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ppe->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPersVacc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPersVacc->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labPersVacc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophyPoSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophyPoSops->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophyPoSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_injuriesLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_injuriesLog->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_injuriesLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workerBioTrained->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workerBioTrained->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workerBioTrained->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyOfficer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyOfficer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyOfficer->id, "answer_id" => $answer_no->id));
        $this->command->info('Question-answers table seeded');

        /* Question parent-child */
        //  Section 1
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labQPolicy->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labQMS->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labQStructure->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labSProcedures->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labRoles->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labDocManReview->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labPers->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_sopsEthCon->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docRecControl->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recControl->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_communication->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_servAgr->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_referralExam->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_extSerSupp->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_purInvCon->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_advisory->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_compFeedback->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_nonConformities->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrAction->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevAction->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_contImpro->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_conRec->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAudits->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_riskMan->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_manReview->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_persMan->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_persTraining->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_competencyAudit->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_Auth->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revStaffPerf->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_Accomo->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_Equip->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_EquiCalib->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_preExamPro->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_valVer->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_meUnc->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_bioRef->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docExPro->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labContPro->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_QCQA->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_repRelRes->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_lis->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labSafeMan->id, "parent_id" => $question_poSops->id));
        //  Section 2
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevActItems->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrActStatus->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_repFromPersonnel->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_envMonLog->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_speRejLog->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_equiCalibManRec->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_iqcRec->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptIntLabCo->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qInd->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_custCompFeed->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_impProRes->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revActPlanDoc->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_perRev->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_feedAssess->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_staffSugg->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAud->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_rskMan->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_quaInd->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_extAssess->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_interLab->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_monResConf->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_suppPerf->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_idConNon->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_contImp->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_followUp->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_volScope->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recForImpro->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_quaObQuaPo->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revOutRec->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_mrMeet->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_repAddRes->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refToImpro->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_effQuaSys->id, "parent_id" => $question_manRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_quaAppro->id, "parent_id" => $question_manRev->id));
        //  Section 3
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_effLead->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_stakeComm->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_adCompSta->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qmsImp->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labSuppMon->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refLabMon->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_safeLabEnv->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_advSer->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_profDevProg->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_addCompReq->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_contPlan->id, "parent_id" => $question_labDir->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_jobDesc->id, "parent_id" => $question_qmsOversight->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qmsProcess->id, "parent_id" => $question_qmsOversight->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qmReport->id, "parent_id" => $question_qmsOversight->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qmPromo->id, "parent_id" => $question_qmsOversight->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qmPart->id, "parent_id" => $question_qmsOversight->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_edProfQua->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_certOrLic->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_CV->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_jobDescr->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_newStaIntro->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_currJob->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_compeAssess->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recContEd->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revStaPerf->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_repOfAcc->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_immuSta->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_empLetter->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_medSurvRec->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qms->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_assWork->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_appLis->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_healthSafety->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labEth->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_confPatInfo->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_supTra->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_contMedEd->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_trainPro->id, "parent_id" => $question_labStaffTra->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_defCrit->id, "parent_id" => $question_staffCompAudit->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_newHire->id, "parent_id" => $question_staffCompAudit->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_existSta->id, "parent_id" => $question_staffCompAudit->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_reTrareAss->id, "parent_id" => $question_staffCompAudit->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevStaMeet->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_sysRecPro->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_complaints->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_commOnSops->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_priorCorrAct->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_evalOfImpro->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hospMeetFeed->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_relOfRep->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recMonMeetNotes->id, "parent_id" => $question_staffMeet->id));
        //  Section 5
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specValVerPro->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_valPerf->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_valInfo->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_perfCharac->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_adeqValVer->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_dataAn->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_valVerRep->id, "parent_id" => $question_equipMethVal->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_quantitative->id, "parent_id" => $question_meQuaTests->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_defPerfReq->id, "parent_id" => $question_meQuaTests->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_calMeasure->id, "parent_id" => $question_meQuaTests->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_equipName->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_manfCont->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_condReceived->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_serialNo->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_dateOfPur->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_outOfSer->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_dateSerEntry->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_location->id, "parent_id" => $question_equipRecMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_serviceContInf->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_serviceProCont->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_decontaRec->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevManRec->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_lastSerDate->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_nextSerDate->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_routineCalib->id, "parent_id" => $question_equipCalibPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_traceCalib->id, "parent_id" => $question_equipCalibPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_reviewCalib->id, "parent_id" => $question_equipCalibPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_certRefMat->id, "parent_id" => $question_equipCalibPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_repOrders->id, "parent_id" => $question_equipRepMon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_verDocEquip->id, "parent_id" => $question_equipRepMon->id));
        //  Section 6
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_allQMS->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_minConfOfIntr->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_audPers->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_causeAnalPerf->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAudFind->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_audRepGen->id, "parent_id" => $question_auditRecomm->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrPrevAct->id, "parent_id" => $question_auditRecomm->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_timeframe->id, "parent_id" => $question_auditRecomm->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_assessPitfalls->id, "parent_id" => $question_riskManage->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_redPitfalls->id, "parent_id" => $question_riskManage->id));
        //  Section 7
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_reaCon->id, "parent_id" => $question_invCon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_batchLot->id, "parent_id" => $question_invCon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_manSuppName->id, "parent_id" => $question_invCon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_receiptDate->id, "parent_id" => $question_invCon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_manPack->id, "parent_id" => $question_invCon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inspRec->id, "parent_id" => $question_invCon->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_invRecComp->id, "parent_id" => $question_labInvSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_consRate->id, "parent_id" => $question_labInvSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_stockCounts->id, "parent_id" => $question_labInvSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_storageWellOrg->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_desigPlaces->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_coldStorage->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_storageAreaMon->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ambientTemp->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_directSunlight->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_adequateVent->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_cleanDustPests->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_accessControl->id, "parent_id" => $question_storageArea->id));
        //  Section 8
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_testReqForm->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptId->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_authReq->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_exam->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_relInfo->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_collDate->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_receiptTime->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_consent->id, "parent_id" => $question_adSampInfo->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_patUniq->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_accRejCrit->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specLog->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_verbalReq->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_splitSamp->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_24hour->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrWorksta->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refLabCons->id, "parent_id" => $question_evalRefLabs->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refLabRej->id, "parent_id" => $question_evalRefLabs->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refSpec->id, "parent_id" => $question_evalRefLabs->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrAcDoc->id, "parent_id" => $question_quaConData->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_resEval->id, "parent_id" => $question_quaConData->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_diffProc->id, "parent_id" => $question_compExRes->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_compStud->id, "parent_id" => $question_compExRes->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_roomTemp->id, "parent_id" => $question_envCondCheck->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_freezers->id, "parent_id" => $question_envCondCheck->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refrigerator->id, "parent_id" => $question_envCondCheck->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_incubators->id, "parent_id" => $question_envCondCheck->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_waterBath->id, "parent_id" => $question_envCondCheck->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "parent_id" => $question_interLabComp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "parent_id" => $question_interLabComp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptProgDisc->id, "parent_id" => $question_interLabComp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "parent_id" => $question_interLabComp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptResCorrAct->id, "parent_id" => $question_interLabComp->id));
        //  Section 9
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_testRequested->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labIdentification->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_examIdentification->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_patientIdentification->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_nameRequester->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_primaryDate->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_primaryTypeSample->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_resultReported->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_biologicalRefrence->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_interpretationSpace->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_authorizingReports->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_dateTime->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_pageNumber->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revisedReports->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revisedReportsDate->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_OriginalReport->id, "parent_id" => $question_testResRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_controlledAccess->id, "parent_id" => $question_authoritiesResp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_controlledAccessEnter->id, "parent_id" => $question_authoritiesResp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_controlledAccessChanging->id, "parent_id" => $question_authoritiesResp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_controlledAccessRelease->id, "parent_id" => $question_authoritiesResp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_verifyResults->id, "parent_id" => $question_authoritiesResp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_sysVerification->id, "parent_id" => $question_electronicVerification->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_RecordValidation->id, "parent_id" => $question_electronicVerification->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_systemChecks->id, "parent_id" => $question_electronicVerification->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docRegularservice->id, "parent_id" => $question_labSystemMentained->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_dcoSystemFailure->id, "parent_id" => $question_labSystemMentained->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_operationEnvironment->id, "parent_id" => $question_labSystemMentained->id));
        //  Section 10
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_details->id, "parent_id" => $question_nonConfDoc->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_acTaken->id, "parent_id" => $question_nonConfDoc->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_extent->id, "parent_id" => $question_nonConfDoc->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_halted->id, "parent_id" => $question_nonConfDoc->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inforReq->id, "parent_id" => $question_nonConfDoc->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_authOfRes->id, "parent_id" => $question_nonConfDoc->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labDataRev->id, "parent_id" => $question_prevActs->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_potNonConf->id, "parent_id" => $question_prevActs->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docPrevAct->id, "parent_id" => $question_prevActs->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_effPrevAct->id, "parent_id" => $question_prevActs->id));
        //  Section 12
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_equipPlacement->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_neededSupplies->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_chairStool->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_freeOfClutter->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_adVent->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_lit->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_climateCon->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_filtersChecked->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_wireCables->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_generator->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_criticalEquip->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_waterHazards->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_deionizedWater->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_clericalWork->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_majSafetySignage->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_bloboPre->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardChem->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_msds->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_persProEquip->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_vaccination->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prophylaxis->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_fireSafety->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_elecSafety->id, "parent_id" => $question_labSafetyManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "parent_id" => $question_hazardMaterials->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardChemStored->id, "parent_id" => $question_hazardMaterials->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "parent_id" => $question_hazardMaterials->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "parent_id" => $question_hazardMaterials->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_elecCords->id, "parent_id" => $question_overallSafety->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_extinguisher->id, "parent_id" => $question_overallSafety->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_fireWarning->id, "parent_id" => $question_overallSafety->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_fireDrills->id, "parent_id" => $question_overallSafety->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_safetyPlan->id, "parent_id" => $question_safetyInspec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_authInsp->id, "parent_id" => $question_safetyInspec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_safetyTrained->id, "parent_id" => $question_safetyInspec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_deficiencies->id, "parent_id" => $question_safetyInspec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_safetyFind->id, "parent_id" => $question_safetyInspec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "parent_id" => $question_stdSafetyEquip->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_centrifuge->id, "parent_id" => $question_stdSafetyEquip->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_handwash->id, "parent_id" => $question_stdSafetyEquip->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_eyewash->id, "parent_id" => $question_stdSafetyEquip->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_spillKit->id, "parent_id" => $question_stdSafetyEquip->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_firstAid->id, "parent_id" => $question_stdSafetyEquip->id));
        $this->command->info('Question parent-child table seeded');
    }
}