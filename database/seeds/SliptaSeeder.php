<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\FacilityType;
use App\Models\FacilityOwner;
use App\Models\County;
use App\Models\Constituency;
use App\Models\Town;
use App\Models\Title;
use App\Models\Facility;
use App\Models\LabLevel;
use App\Models\LabAffiliation;
use App\Models\LabType;
use App\Models\AuditType;
use App\Models\Assessment;
use App\Models\Section;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Note;
class SliptaSeeder extends Seeder
{
    public function run()
    {
    	/* Users table */
    	$usersData = array(
            array(
                "username" => "admin", "password" => Hash::make("password"), "email" => "admin@slipta.org",
                "name" => "Kitsao Emmanuel", "gender" => "0", "phone"=>"0722000000", "address" => "P.O. Box 59857-00200, Nairobi"
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

            array("name" => "manage_users", "display_name" => "Can manage users"),
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

        //Assign roles to the other users
       
        /* MFL seeds */
        //  Facility Types
        $facilityTypes = array(
            array("name" => "Medical Clinic", "user_id" => "1"),
            array("name" => "Training Institution in Health (Stand-alone)", "user_id" => "1"),
            array("name" => "Dispensary", "user_id" => "1"),
            array("name" => "VCT Centre (Stand-Alone)", "user_id" => "1"),
            array("name" => "Nursing Home", "user_id" => "1"),
            array("name" => "Sub-District Hospital", "user_id" => "1"),
            array("name" => "Health Centre", "user_id" => "1"),
            array("name" => "Dental Clinic", "user_id" => "1"),
            array("name" => "Laboratory (Stand-alone)", "user_id" => "1"),
            array("name" => "Eye Centre", "user_id" => "1"),
            array("name" => "Maternity Home", "user_id" => "1"),
            array("name" => "Radiology Unit", "user_id" => "1"),
            array("name" => "District Hospital", "user_id" => "1"),
            array("name" => "Provincial General Hospital", "user_id" => "1"),
            array("name" => "Other Hospital", "user_id" => "1")
        );
        foreach ($facilityTypes as $facilityType) {
            FacilityType::create($facilityType);
        }
        $this->command->info('Facility Types table seeded');

        //  Facility Owners
        $facilityOwners = array(
            array("name" => "Christian Health Association of Kenya", "user_id" => "1"),
            array("name" => "Private Enterprise (Institution)", "user_id" => "1"),
            array("name" => "Ministry of Health", "user_id" => "1"),
            array("name" => "Non-Governmental Organization", "user_id" => "1"),
            array("name" => "Private Practice - Nurse / Midwife", "user_id" => "1"),
            array("name" => "Private Practice - General Practitioner", "user_id" => "1"),
            array("name" => "Kenya Episcopal Conference-Catholic Secretariat", "user_id" => "1"),
            array("name" => "Company Medical Service", "user_id" => "1"),
            array("name" => "Other Faith Based", "user_id" => "1")
        );
        foreach ($facilityOwners as $facilityOwner) {
            FacilityOwner::create($facilityOwner);
        }
        $this->command->info('Facility Owners table seeded');
        //  Counties
        $counties = array(
            array("name" => "Baringo", "hq" => "Kabarnet", "user_id" => "1"),
            array("name" => "Bomet", "hq" => "Bomet", "user_id" => "1"),
            array("name" => "Bungoma", "hq" => "Bungoma", "user_id" => "1"),
            array("name" => "Busia", "hq" => "Busia", "user_id" => "1"),
            array("name" => "Elgeyo Marakwet", "hq" => "Iten", "user_id" => "1"),
            array("name" => "Embu", "hq" => "Embu", "user_id" => "1"),
            array("name" => "Garissa", "hq" => "Garissa", "user_id" => "1"),
            array("name" => "Homa Bay", "hq" => "Homa Bay", "user_id" => "1"),
            array("name" => "Isiolo", "hq" => "Isiolo", "user_id" => "1"),
            array("name" => "Kajiado", "hq" => "Kajiado", "user_id" => "1"),
            array("name" => "Kakamega", "hq" => "Kakamega", "user_id" => "1"),
            array("name" => "Kericho", "hq" => "Kericho", "user_id" => "1"),
            array("name" => "Kiambu", "hq" => "Kiambu", "user_id" => "1"),
            array("name" => "Kilifi", "hq" => "Kilifi", "user_id" => "1"),
            array("name" => "Kirinyaga", "hq" => "Kerugoya", "user_id" => "1"),
            array("name" => "Kisii", "hq" => "Kisii", "user_id" => "1"),
            array("name" => "Kisumu", "hq" => "Kisumu", "user_id" => "1"),
            array("name" => "Kitui", "hq" => "Kitui Town", "user_id" => "1"),
            array("name" => "Kwale", "hq" => "Kwale", "user_id" => "1"),
            array("name" => "Laikipia", "hq" => "Nanyuki", "user_id" => "1"),
            array("name" => "Lamu", "hq" => "Lamu", "user_id" => "1"),
            array("name" => "Machakos", "hq" => "Machakos", "user_id" => "1"),
            array("name" => "Makueni", "hq" => "Wote", "user_id" => "1"),
            array("name" => "Mandera", "hq" => "Mandera", "user_id" => "1"),
            array("name" => "Marsabit", "hq" => "Marsabit", "user_id" => "1"),
            array("name" => "Meru", "hq" => "Meru", "user_id" => "1"),
            array("name" => "Migori", "hq" => "Migori", "user_id" => "1"),
            array("name" => "Mombasa", "hq" => "Mombasa", "user_id" => "1"),
            array("name" => "Murang\'a", "hq" => "Murang\'a", "user_id" => "1"),
            array("name" => "Nairobi", "hq" => "Nairobi", "user_id" => "1"),
            array("name" => "Nakuru", "hq" => "Nakuru", "user_id" => "1"),
            array("name" => "Nandi", "hq" => "Kapsabet", "user_id" => "1"),
            array("name" => "Narok", "hq" => "Narok", "user_id" => "1"),
            array("name" => "Nyamira", "hq" => "Nyamira", "user_id" => "1"),
            array("name" => "Nyandarua", "hq" => "Ol Kalou", "user_id" => "1"),
            array("name" => "Nyeri", "hq" => "Nyeri", "user_id" => "1"),
            array("name" => "Samburu", "hq" => "Maralal", "user_id" => "1"),
            array("name" => "Siaya", "hq" => "Siaya", "user_id" => "1"),
            array("name" => "Taita Taveta", "hq" => "Voi", "user_id" => "1"),
            array("name" => "Tana River", "hq" => "Hola", "user_id" => "1"),
            array("name" => "Tharaka Nithi", "hq" => "Chuka", "user_id" => "1"),
            array("name" => "Trans Nzoia", "hq" => "Kitale", "user_id" => "1"),
            array("name" => "Turkana", "hq" => "Lodwar", "user_id" => "1"),
            array("name" => "Uasin Gishu", "hq" => "Eldoret", "user_id" => "1"),
            array("name" => "Vihiga", "hq" => "Mbale", "user_id" => "1"),
            array("name" => "Wajir", "hq" => "Wajir", "user_id" => "1"),
            array("name" => "West Pokot", "hq" => "Kapenguria", "user_id" => "1")

        );
        foreach ($counties as $county) {
            County::create($county);
        }
        $this->command->info('Counties table seeded');

        /* Constituencies table */
        $constituencies = array(
            array("name" => "Ganze", "county_id" => "13", "user_id" => "1"),
        );
        foreach ($constituencies as $constituency) {
            Constituency::create($constituency);
        }
        $this->command->info('Constituencies table seeded');
        /* Towns table */
        $towns = array(
            array("name" => "Mombasa", "constituency_id" => "1", "postal_code" => "80100", "user_id" => "1"),
            array("name" => "Kilifi", "constituency_id" => "1", "postal_code" => "80108", "user_id" => "1"),
            array("name" => "Kaloleni", "constituency_id" => "1", "postal_code" => "80105", "user_id" => "1"),
        );
        foreach ($towns as $town) {
            Town::create($town);
        }
        $this->command->info('Towns table seeded');

        /* Titles table */
        $titles = array(
            array("name" => "Nursing Officer in Charge", "user_id" => "1"),
            array("name" => "Clinical Officer", "user_id" => "1"),
            array("name" => "Doctor In Charge", "user_id" => "1"),
            array("name" => "Hospital Director", "user_id" => "1"),
            array("name" => "Doctor In Charge", "user_id" => "1"),
            array("name" => "Medical Superintendant", "user_id" => "1")
        );
        foreach ($titles as $title) {
            Title::create($title);
        }
        $this->command->info('Job titles table seeded');
        /* Lab Levels */
        $labLevels = array(
            array("name" => "National", "user_id" => "1"),
            array("name" => "County Referral", "user_id" => "1"),
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
            array("name" => "G.O.K.", "user_id" => "1"),
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

        /* Facilities table */
        $facilities = array(
            array("code" => "19704", "name" => "ACK Nyandarua Medical Clinic", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> "Situated within Captain township 4km from olkalou town towards NRB","nearest_town" => "Captain","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 48", "town_id" => "1", "in_charge" => "Eliud Mwangi Kithaka", "title_id" => "1", "operational_status" => "1", "user_id" => "1"),
            array("code" => "10039", "name" => "ACK Tumaini Medical Clinic", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Gatundu town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 84", "town_id" => "3", "in_charge" => "Assumpta", "title_id" => "1", "operational_status" => "1", "user_id" => "1"),
            array("code" => "17473", "name" => "ASPE Medical Clinic", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Nyeri town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 229", "town_id" => "3", "in_charge" => "Jane Mwaita", "title_id" => "1", "operational_status" => "1", "user_id" => "1"),
            array("code" => "11195", "name" => "Acode Medical Clinic Maungu", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Maungu town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 18", "town_id" => "2", "in_charge" => "Sr  Kameru", "title_id" => "1", "operational_status" => "1", "user_id" => "1"),
        );
        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
        $this->command->info('Facilities table seeded');

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
        $answerYes = Answer::create(array("name" => "Yes", "description" => "Yes(Y)", "user_id" => "1"));
        $answerNo = Answer::create(array("name" => "No", "description" => "No(N)", "user_id" => "1"));
        $answerPartial = Answer::create(array("name" => "Partial", "description" => "Partial(P)", "user_id" => "1"));
        $answerDaily = Answer::create(array("name" => "Daily", "description" => "", "user_id" => "1"));
        $answerWeekly = Answer::create(array("name" => "Weekly", "description" => "", "user_id" => "1"));
        $answerEveryRun = Answer::create(array("name" => "W/Every Run", "description" => "With Every Run", "user_id" => "1"));
        
        $this->command->info('Answers table seeded');

        /* Notes */
        $note_intro = Note::create(array("name" => "1.0 Introduction", "description" => "<p>Laboratory services are an essential component in the diagnosis and treatment of patients infected with the human immunodeficiency virus (HIV), malaria,<i>Mycobacterium tuberculosis</i> (TB), sexually transmitted diseases (STDs), and other infectious diseases. Presently, the laboratory infrastructure and test quality for all types of clinical laboratories remain in its nascent stages in most countries in Africa. Consequently, there is an urgent need to strengthen laboratory systems and services. The establishment of a process by which laboratories can achieve accreditation at international standards is an invaluable tool for countries to improve the quality of laboratory services.</p><p>In accordance with WHO's core functions of setting standards and building institutional capacity, WHO-AFRO has established the <strong>Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA)</strong> to strengthen laboratory systems of its Member States. The <strong>Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA)</strong> is a framework for improving quality of public health laboratories in developing countries to achieve ISO 15189 standards. It is a process that enables laboratories to develop and document their ability to detect, identify, and promptly report all diseases of public health significance that may be present in clinical specimens. This initiative was spearheaded by a number of critical resolutions, including Resolution AFR/RC58/R2 on Public Health Laboratory Strengthening, adopted by the Member States during the 58th session of the Regional Committee in September 2008 in Yaounde, Cameroon, and the Maputo Declaration to strengthen laboratory systems. This quality improvement process towards accreditation further provides a learning opportunity and pathway for continuous improvement, a mechanism for identifying resource and training needs, a measure of progress, and a link to the WHO-AFRO National Health Laboratory Service Networks.</p><p>Clinical, public health, and reference laboratories participating in the <strong>Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA)</strong> are reviewed bi-annually. Recognition is given for the upcoming calendar year based on progress towards meeting requirements set by international standards and on laboratory performance during the 12 months preceding the SLIPTA audit, relying on complete and accurate data, usually from the past 1-13 months to 1 month prior to evaluation.</p><hr><h4>2.0 Scope</h4><hr><p>This checklist specifies requirements for quality and competency aimed to develop and improve laboratory services to raise quality to established national standards. The elements of this checklist are based on ISO standard 15189:2007(E) and, to a lesser extent, CLSI guideline GP26-A4; Quality Management System: A Model for Laboratory Services; Approved Guideline—Fourth Edition.</p><p>Recognition is provided using a five star tiered approach, based on a bi-annual on-site audit of laboratory operating procedures, practices, and performance.</p><p>The inspection checklist score will correspond to the number of stars awarded to a laboratory in the following manner:<p><div class='table-responsive'><table class='table table-striped table-bordered table-hover'><tbody><tr><td><h4>No Stars</h4><p>(0 - 142 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(143 - 165 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(166 - 191 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(192 - 217 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(218 - 243 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(244 - 258 pts)</p><p><i>&ge; 95%</i></p></td></tr></tbody></table></div><p>A laboratory that achieves less than a passing score on any one of the applicable standards will work with the Regional Office Laboratory Coordinator to:</p><ul><li>Identify areas where improvement is needed.</li><li>Develop and implement a work plan.</li><li>Monitor laboratory progress.</li><li>Conduct re-testing where required.</li><li>Continue steps to achieve full accreditation.</li></ul><hr><h4>Parts of the Audit</h4><hr><p>This laboratory audit checklist consists of three parts:</p><h3>Part I: Laboratory Profile</h3><h3>Part II: Laboratory Audits<p><small>Evaluation of laboratory operating procedures, practices, and tables for reporting performance </small></p></h3><h3>Part III: Summary of Audit Findings<p><small>Summary of findings of the SLIPTA audit and action planning worksheet</small></p></h3>", "audit_type_id" => "1", "user_id" => "1"));
        $note_prelude = Note::create(array("name" => "Prelude", "description" => "<p>Laboratory audits are an effective means to 1) determine if a laboratory is providing accurate and reliable results; 2) determine if the laboratory is well-managed and is adhering to good laboratory practices; and 3) identify areas for improvement. </p><p>Auditors complete this audit using the methods below to evaluate laboratory operations per checklist items and to document findings in detail.</p><ul><li><strong>Review laboratory records &nbsp;</strong>to verify that the laboratory quality manual, policies, personnel files, equipment maintenance records; audit trails, incident reports, logs, Standard Operating Procedures (SOPs) and other manuals (e.g., safety manual) are complete, current, accurate, and annually reviewed.</li><li><strong>Observe laboratory operations &nbsp;</strong>to ensure: <ul><li>Laboratory testing follows written policies and procedures in pre-analytic, analytic and post-analytic phases of laboratory testing;</li><li>Laboratory procedures are appropriate for the testing performed;</li><li>Deficiencies and nonconformities identified are adequately investigated and resolved within the established timeframe.</li></ul></li><li><strong>Ask open-ended questions &nbsp;</strong>to clarify documentation seen and observations made. Ask questions like, \"show me how...\" or \"tell me about...\" It is often not necessary to ask all the checklist questions verbatim. An experienced auditor can often learn to answer multiple checklist questions through open-ended questions with the laboratory staff.</li><li><strong>Follow a specimen through the laboratory &nbsp;</strong>from collection through registration, preparation, aliquoting, analyzing, result verification, reporting, printing, and post-analytic handling and storing samples to determine the strength of laboratory systems and operations.</li><li><strong>Confirm that each result or batch can be traced &nbsp;</strong>back to a corresponding internal quality control (IQC) run and that the IQC was passed. Confirm that IQC results are recorded for all IQC runs and reviewed for validation.</li><li><strong>Confirm PT results &nbsp;</strong>and the results are reviewed and corrective action taken as required.</li><li><strong>Evaluate the quality and efficiency of supporting work areas &nbsp;</strong>(e.g., phlebotomy, data registration and reception, messengers, drivers, cleaners, IT, etc).</li><li><strong>Talk to clinicians &nbsp;</strong>to learn the users' perspective on the laboratory's performance. Clinicians often are a good source of information regarding the quality and efficiency of the laboratory. Notable findings can be documented in the Summary and Recommendations section at the end of the checklist.</li></ul><hr><h4>AUDIT SCORING</h4><hr><p>This Stepwise Laboratory Quality Improvement Process Towards Accreditation Checklist contains 111 main sections (a total of 334 questions) for a total of 258 points. Each item has been awarded a point value of 2, 3, 4 or 5 points--based upon relative importance and/or complexity. Responses to all questions must be, \"yes\", \"partial\", or \"no\".</p><ul><li>Items marked \"yes\" receive the corresponding point value (2, 3, 4 or 5 points).<strong><u>All</u> elements of a question must be present in order to indicate \"yes\" for a given item and thus award the corresponding points.</strong><p><strong>NOTE:</strong> items that include \"tick lists\" must receive all \"yes\" and/or \"n/a\" responses to be marked \"yes\" for the overarching item.</p></li><li>Items marked <i>\"partial\"</i> receive 1 point.</li><li>Items marked <i>\"no\"</i> receive 0 points.</li></ul><p>When marking \"partial\" or \"no\", notes should be written in the comments field to explain why the laboratory did not fulfill this item to assist the laboratory with addressing these areas of identified need following the audit.</p><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td colspan=\"2\"><strong>Audit Score Sheet</strong></td></tr><tr><td><i>Section</i></td><td><i>Total Points</i></td></tr><tr><td><strong>Section 1 &nbsp;<strong>Documents & Records</td><td><strong>25</strong></td></tr><tr><td><strong>Section 2 &nbsp;<strong>Management Reviews</td><td><strong>12</strong></td></tr><tr><td><strong>Section 3 &nbsp;<strong>Organization & Personnel</td><td><strong>22</strong></td></tr><tr><td><strong>Section 4 &nbsp;<strong>Client Management & Customer Service</td><td><strong>8</strong></td></tr><tr><td><strong>Section 5 &nbsp;<strong>Equipment</td><td><strong>33</strong></td></tr><tr><td><strong>Section 6 &nbsp;<strong>Purchasing & Inventory</td><td><strong>10</strong></td></tr><tr><td><strong>Section 7 &nbsp;<strong>Purchasing & Inventory</td><td><strong>30</strong></td></tr><tr><td><strong>Section 8 &nbsp;<strong>Process Control and Internal & External Quality Audit</td><td><strong>14</strong></td></tr><tr><td><strong>Section 9 &nbsp;<strong>Information Management</td><td><strong>43</strong></td></tr><tr><td><strong>Section 10 &nbsp;<strong>Corrective Action</td><td><strong>8</strong></td></tr><tr><td><strong>Section 11 &nbsp;<strong>Occurrence/Incident Management & Process Improvement</td><td><strong>10</strong></td></tr><tr><td><strong>Section 12 &nbsp;<strong>Facilities and Safety</td><td><strong>43</strong></td></tr><tr><td><strong>TOTAL SCORE<strong></td><td><strong>258</strong></td></tr></tbody></table></div><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td><h4>No Stars</h4><p>(0 - 142 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(143 - 165 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(166 - 191 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(192 - 217 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(218 - 243 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(244 - 258 pts)</p><p><i>&ge; 95%</i></p></td></tr></tbody></table></div>", "audit_type_id" => "1", "user_id" => "1"));
        $note_ethical = Note::create(array("name" => "Ethical Principles", "description" => "<p><strong>Laboratories shall uphold the principle that the welfare and interest of the patient are paramount and patients should be treated fairly and without discrimination. (ISO 15189 Annex C.2.1)</strong></p><p>Every medical laboratory shall provide its services to all users in a manner that respects their health rights and without discrimination. (ISO 15189 Annex C 2.2)</p><p>Every medical laboratory shall ensure that patient consent is obtained for all procedures carried out on the patient. In emergency situations, if consent is not possible under these circumstances, necessary procedures may be carried out, provided they are in the best interest of the patient. (ISO 15189 Annex C 4.1)</p><p>Medical laboratories should have in place policy guidelines that address conflicts of interest, undue internal or external pressure, and confidentiality that could influence the credibility of the work conducted and information generated by the laboratory. (ISO 15189 Clause 4.1.4 and 4.1.5 b, c, d and 5.1.13)</p><p>Personnel employed within medical laboratories shall not compromise their organization by engaging in activities that could adversely affect quality of work, competence, impartiality, judgment or operational integrity. (ISO 15189 Clause 4.1.5 b, d).</p>", "audit_type_id" => "1", "user_id" => "1"));
        $note_certification = Note::create(array("name" => "SLIPTA Certification", "description" => "<p><ol><li><strong>Test results are reported by the laboratory on at least 80% of specimens within the turnaround time specified (and documented) by the laboratory in consultation with its clients.</strong> <i>Turnaround time to be interpreted as time from receipt of specimen in laboratory until results reported.</i><strong> DATA NOT COLLECTED ON THIS ELEMENT</strong><li><strong>Internal quality control (IQC) procedures are practiced for all testing methods used by the laboratory.</strong><br />Ordinarily, each test kit has a set of positive and negative controls that are to be included in each test run. These controls included with the test kit are considered internal controls, while any other controls included in the run are referred to as external controls. QC data sheets and summaries of corrective action are retained for documentation and discussion with auditor.</li><li><strong>The scores on the two most recent WHO AFRO approved proficiency tests are 80% or better.</strong><br />Proficiency test (PT) results must be reported within 15 days of panel receipt. Laboratories that receive less than 80% on two consecutive PT challenges will lose their certification until such time that they are able to successfully demonstrate achievement of 80% or greater on two consecutive PT challenges. Unacceptable PT results must be addressed and corrective action taken.<br /><i>NOTE: A laboratory that has failed to demonstrate achievement of 80% or greater on the two most recent PT challenges will not be awarded any stars, regardless of the checklist score they received upon audit.</i></li></ol></p><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td colspan=\"3\"><strong>Score on annual on-site inspection is at least 55%</strong> (at least 143 points):</td><td></td><td>%</td><td></td></tr><tr><td><h4>No Stars</h4><p>(0 - 142 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(143 - 165 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(166 - 191 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(192 - 217 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(218 - 243 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(244 - 258 pts)</p><p><i>&ge; 95%</i></p></td></tr><tr><td>Lead Auditor Signature</td><td colspan=\"2\"></td><td>Date</td><td colspan=\"2\"></td></tr></tbody></table></div><hr>SOURCES CONSULTED<hr><p>AS 4633 (ISO 15189) Field Application Document: 2009</p><p>Centers for Disease Control - Atlanta - Global AIDS Program. (2008). Laboratory Management Framework and Guidelines. Atlanta, GA: Katy Yao, PhD.</p><p>CLSI/NCCLS. <i>Application of a Quality Management System Model for Laboratory Services; Approved Guideline--Third Edition.</i> CLSI/NCCLS document GP26-A3. Wayne, PA: NCCLS; 2004. www.clsi.org</p><p>CLSI/NCCLS. <i>A Quality Management System Model for Health Care; Approved Guideline--Second Edition.</i> CLSI/NCCLS document HS01-A2. Wayne, PA: NCCLS; 2004. www.clsi.org</p><p>College of American Pathologists, USA. (2010). Laboratory General and Chemistry and Toxicology Checklists.</p><p>Guidance for Laboratory Quality Management System in the Caribbean - A Stepwise Improvement Process. (2012)</p><p>International Standards Organization, Geneva (2007) Medical Laboratories - ISO 15189: Particular Requirements for Quality and Competence, 2nd Edition</p><p>Ministry of Public Health, Thailand. (2008). Thailand Medical Technology Council Quality System Checklist.</p><p>National Institutes of Health, (2007, Feb 05). DAIDS Laboratory Assessment Visit Report. Retrieved July 8, 2008, from National Institutes of Health Web site: <a href=\"http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm\"> http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm</a></p><p>National Institutes of Health, (2007, Feb 05). Chemical, Laboratory: Quality Assurance and Quality Improvement Monitors. CHECKLIST FOR SITE SOP REQUIRED ELEMENTS, Retrieved July 8, 2008, from <a href=\"http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm\">http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm</a> </p><p>National Institutes of Health, (2007, Feb 05). Laboratory: Chemical, Biohazard and Occupational Safety, Containment and Disposal. CHECKLIST FOR SITE SOP REQUIRED ELEMENTS, Retrieved July 8, 2008, from <a href=\"http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm\">http://www3.niaid.nih.gov/research/resources/DAIDSClinRsrch/Laboratories.htm</a></p><p>PPD, Wilmington, North Carolina, (2007). Laboratory Report.</p><p>South African National Accreditation System (SANAS). (2005). Audit Checklist, SANAS 10378:2005.</p><p>USAID Deliver Project. The Logistics Handbook. (2007). Task Order 1.</p>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 1
        $note_labQM = Note::create(array("name" => "Laboratory Quality Manual", "description" => "<i><small><strong>Standard:</strong> A quality manual should be available that summarizes the laboratory's quality program, includes policies that address all areas of the laboratory service, and identifies the goals and objectives of the quality program. The quality manual should include policies (processes and procedures) for all areas of the laboratory service and should address all of the quality system essentials (QSE).<br /><strong>ISO 15189: 4.2.3, 4.2.4</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docInfoControl = Note::create(array("name" => "Document and Information Control System", "description" => "<i><small><strong>Standard:</strong> A document control system should be in place to ensure that records and all copies of policies/procedures are current, read by personnel, authorized by proper authorities, reviewed annually, and immediately prior versions filed separately as per national policy. There must be a procedure/policy on document control. Documents must be uniquely identified to include title, page numbers, and authority of issue, document number, versions, effective date, and author. There must be a procedure/policy on document control. Documents must be uniquely identified to include tile, page numbers, and authority of issue, document number, versions, effective date, and author.<br /><strong>ISO 15189: 4.3.1, 4.3.2, 4.3.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docRec = Note::create(array("name" => "Documents and Records", "description" => "<i><small><strong>Standard:</strong> An up-to-date Master List that comprehensively details all laboratory documents, policies, and procedures should be readily accessible in either hard copy or electronic form. These should be retrievable within a timely manner. If documents and records are maintained in electronic form they should be backed up on CD or other media.<br /><strong>ISO 15189: 4.3.2 (b,c):</strong> \"Procedures shall be adopted to ensure that... b) a list, also referred to as a document control log, identifying the current valid revisions and their distribution is maintained; c) only currently authorized versions of appropriate documents are available for active use at relevant locations.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_poSops = Note::create(array("name" => "Laboratory Policies and Standard Operating Procedures", "description" => "<i><small><strong>Standard:</strong> Standard Operating Procedures (SOPs) should be established and maintained up-to-date for all tasks performed within the laboratory, safety and waste disposal, document control, specimen collection and processing, inventory control, procurement, and quality assurance. SOPs should be reviewed for accuracy and relevance on an annual basis. All policies and procedures should be approved by an authorized person.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_poSopsAcc = Note::create(array("name" => "Policy and SOPs Accessibility", "description" => "<i><small><strong>Standard:</strong> All procedures shall be documented and be available at the workstation for relevant staff. Documented procedures and necessary instructions shall be available in a language commonly understood by the staff in the laboratory.<br /><strong>ISO 15189: 5.5.3, 4.3.2 Part C</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_poSopsComm = Note::create(array("name" => "Policies and SOPs Communication", "description" => "<i><small><strong>Standard:</strong> Policies, processes, programs, procedures and instructions shall be documented and communicated to all relevant staff and management must ensure that these documents are understood by staff and implemented.<br /><strong>ISO 15189: 4.2.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_docContLog = Note::create(array("name" => "Document Control Log", "description" => "<i><small><strong>Standard:</strong> The document control log or other documentation should capture the date the policy/procedure went into service, schedule of review, the identity of the reviewers, and the date of discontinuation.<br /><strong>ISO 15189: 4.3.1, 4.3.2 Part (e) and (f): 4.3.2 -</strong> \"Procedures shall be adopted to ensure that e) invalid or obsolete documents are promptly removed from all points of use, or otherwise assured against inadvertent use; and f) retained or archived superseded documents are appropriately identified to prevent their inadvertent use.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_discPoSops = Note::create(array("name" => "Discontinued Policies and SOPs", "description" => "<i><small><strong>Standard:</strong> Discontinued policies/procedures should be retained or archived in a separate file or place clearly marked to avoid use for the period of time required by laboratory and/or national policy.<br /><strong>ISO 15189: 4.3.1, 4.3.2 Part (e) and (f) - see above</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_dataFiles = Note::create(array("name" => "Data Files", "description" => "<i><small><strong>Standard:</strong> Copies or files of results should be archived. The length of time that reported data are retained may vary; however, the reported results shall be retrievable for as long as medically relevant or as required by national, regional or local requirements.<br /><strong>ISO 15189: 5.8.6, 4.13.2, 4.13.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_arcRes = Note::create(array("name" => "Archived Results Accessibility", "description" => "<i><small><strong>Standard:</strong> Archived patient results must be easily, readily, and completely retrievable within a timeframe consistent with patient care needs.<br /><strong>ISO 15189: 5.8.6, 4.13.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 2
        $note_workBudget = Note::create(array("name" => "Workplan and Budget", "description" => "<i><small><strong>Standard:</strong> Laboratories should be involved in the development of the work plan and budget for their activities. The workplan should reflect the findings of management reviews in its goals, objectives, and actions. Not all labs will have budgetary authority as higher levels of management may have direct control for budget-making. If the laboratory does not develop these guiding documents itself, it must communicate with upper management effectively about these areas, including providing a forecast of needs.<br /><strong>ISO 15189: 4.1.5 Part (a) and (h)</strong> \"Laboratory management shall have responsibility for the design, implementation, maintenance and improvement of the quality management system.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_quaTecRec = Note::create(array("name" => "Review of Quality and Technical Records", "description" => "<i><small><strong>Standard:</strong> There must be documentation that the laboratory manager/supervisor or a designee reviews the quality program regularly. The review must ensure that recurrent problems have been addressed, and that new or redesigned activities have been evaluated.<br /><strong>ISO 15189: 4.15.2 (a) - (m).</strong> Management review shall include 4.15.2. (a) through (m).</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_annualQMS = Note::create(array("name" => "Annual Review of Quality Management Systems", "description" => "<i><small><strong>Standard:</strong> There must be documentation that the head of laboratory or a designee reviews the quality program at least once every 12 months. The review must ensure that recurrent problems have been addressed, and that new or redesigned activities have been evaluated.<br /><strong>ISO 15189: 4.15</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qmsImp = Note::create(array("name" => "Quality Management System Improvement Measures", "description" => "<i><small><strong>Standard:</strong> The monthly and annual reviews of the quality management system must be used as opportunities for identifying nonconformities and areas for improvement. Action plans for improvement shall be developed, documented and implemented, as appropriate.<br /><strong>ISO 15189: 4.12.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_commSys = Note::create(array("name" => "Communications System on Laboratory Operations", "description" => "<i><small><strong>Standard:</strong> The laboratory must have a system in place for communicating with management regarding laboratory operations and effectiveness of the quality management system. The communication and follow-up must be documented<br /><strong>ISO 15189: 4.1.6</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 3
        $note_workSchCo = Note::create(array("name" => "Workload, Schedule and Coverage", "description" => "<i><small><strong>Standard:</strong> Work schedules show who is in the laboratory and when they should be available. Work schedules are normally provided to hospital management showing laboratory coverage. There shall be enough staff resources adequate to cover the work as required and tasks should be prioritized, organized, and coordinated based upon personnel skill level, workloads, and the task completion timeframe<br /><strong>ISO 15189: 5.1.5</strong> \"There shall be staff resources adequate to the undertaking of the work required and the carrying out of other functions of the quality management system.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_duRoDa = Note::create(array("name" => "Duty Roster And Daily Routine", "description" => "<i><small><strong>Standard:</strong> A duty roster designates specific laboratory personnel to specific workstations and workstation tasks list the tasks associated with a specific workstation. E.g. personnel X assigned to hematology (duty roster) expected to perform specific tasks (workstation tasks). Daily routines should be prioritized, organized and coordinated to achieve optimal service delivery for patients.<br /><strong>ISO 15189: 5.1.7</strong> \"Laboratory management shall authorize personnel to perform particular tasks such as sampling, examination and operation of particular types of equipment, including use of computers in the laboratory information system.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_orgChart = Note::create(array("name" => "Organizational Chart and External/Internal Reporting Systems", "description" => "<i><small><strong>Standard:</strong> An up-to-date organizational chart and/or narrative description should be available detailing the external and internal reporting relationships for laboratory personnel. The organizational chart or narrative should clearly show how the laboratory is linked to the rest of the hospital and laboratory services where applicable<br /><strong>ISO 15189: 5.1.1, 4.1.5 Part (e & j)</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qmsOversight = Note::create(array("name" => "Quality Management System Oversight", "description" => "<i><small><strong>Standard:</strong> There should be a quality manager (however named) with delegated authority to oversee compliance with the requirements of the quality management system. This quality manager should report directly to the level of laboratory management at which decisions are made on laboratory policy and resources.<br /><strong>ISO 15189: 4.1.5 Part ( i)</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_perFiSys = Note::create(array("name" => "Personnel Filing System", "description" => "<i><small><strong>Standard:</strong> Personnel files should be maintained for all current staff. Documentation should include job description, qualifications, training, experience, competency assessment records, periodic performance review records, and records of vaccination, injuries, or workplace accidents.<br /><strong>ISO 15189: 5.1.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_staffCompetency = Note::create(array("name" => "Staff Competency audit and Training", "description" => "<i><small><strong>Standard:</strong> Newly hired lab staff should be assessed for competency before performing independent duties and again within six months. All lab staff should be regularly assessed for testing competency at least once a year. Staff assigned to a new section should be assessed before fully assuming independent duties. When deficiencies are noted, retraining and reassessment should be planned and documented. If the employee's competency remains below standard, further action might include supervisory review of work, re-assignment of duties, or other appropriate actions. Records of competency assessments and resulting actions should be retained in personnel files and/or quality records. Records should show which skills were assessed, how those skills were measured, and who performed the assessment.<br /><strong>ISO 15189: 5.1.11:</strong> \"The competency of each person to perform assigned tasks shall be assessed following training and periodically thereafter. Retraining and reassessment shall occur when necessary.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labStaffTra = Note::create(array("name" => "Laboratory Staff Training", "description" => "<i><small><strong>Standard:</strong> In line with national laboratory training plans, each laboratory should have functional training policies and procedures that meet the needs of laboratory personnel through both internal and external training.<br /><strong>ISO 15189: 4.12.5, 5.1.6, 5.1.9</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_staffMeet = Note::create(array("name" => "Staff Meetings", "description" => "<i><small><strong>Standard:</strong> \"Laboratory management shall ensure that appropriate communication processes are established within the laboratory and that communication takes place regarding the effectiveness of the quality management system.\" The laboratory should hold regular staff meetings to ensure communication within the laboratory. Meetings should have recorded notes to facilitate review of progress over time.<br /><strong>ISO 15189: 4.1.6</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 4
        $note_adviceTra = Note::create(array("name" => "Advice and Training by Qualified Staff", "description" => "<i><small><strong>Standard:</strong> Professionally-qualified staff should provide advice on sample type, examination choice, frequency, and results interpretation.<br /><strong>ISO 15189:4.7; 4.12.5</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labHandbook = Note::create(array("name" => "Laboratory Handbook for Clients", "description" => "<i><small><strong>Standard:</strong> The laboratory should provide its clients with a handbook that outlines the laboratory's hours of operation, available tests, specimen collection instructions, packaging and shipping directions, and expected turnaround times.<br /><strong>ISO 15189: 4.7, 4.12.5, 5.5.6</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_commOnDelays = Note::create(array("name" => "Communication Policy on Delays in Service ", "description" => "<i><small><strong>Standard:</strong> There shall be a policy for notifying the requester when an examination is delayed. Such notification shall be documented for both service interruption and resumption as well as related feedback from clinicians. This does not mean that the clinical personnel are to be notified of all delays of examination, but only in those situations where the delay could compromise patient care.<br /><strong>ISO 15189: 5.8.11</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_evalTool = Note::create(array("name" => "Evaluation Tool and Follow up", "description" => "<i><small><strong>Standard:</strong> The laboratory should measure the satisfaction of client clinicians and patients regarding its services, either on an ongoing basis or through episodic solicitations.<br /><strong>ISO 15189: 4.8, 4.15.2 Part (h)</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 5
        $note_properEquip = Note::create(array("name" => "Adherence to Proper Equipment Protocol", "description" => "<i><small><strong>Standard:</strong> Equipments should be properly placed as specified in user manual away from the following but not limited to water, direct sunlight, vibrations, in traffic and with more than 75% of the base of the equipment sitting on the bench top to avoid tip-over.<br /><strong>ISO 15189: 5.3.3</strong> \"Each item of equipment shall be uniquely labeled, marked, or otherwise identified.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipMethVal = Note::create(array("name" => "Equipment and Method Validation/ Verification and Documentation", "description" => "<i><small><strong>Standard:</strong> Newly introduced methods or equipment should be validated onsite to ensure that their introduction yields performance equal to or better than the previous method or equipment. Validation may be done versus the method or equipment being replaced or the prevailing gold-standard. An SOP should be in place to guide method validation.<br /><strong>ISO 15189: 5.5.2</strong> \"The laboratory shall use only validated procedures for confirming that the examination procedures are suitable for the intended use.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipRecMain = Note::create(array("name" => "Equipment Record Maintenance", "description" => "<i><small><strong>Standard:</strong> Records shall be maintained for each item of equipment used in the performance of examinations. Such equipment list must include major analyzers as well as ancillary equipment like centrifuges, water baths, rotators, fridges, pipettes, timers, printers, computers.<br /><strong>ISO 15189: 5.3.4</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipManRec = Note::create(array("name" => "Equipment Maintenance Records", "description" => "<i><small><strong>Standard:</strong> Maintenance records must be maintained for each item of equipment used in the performance of examinations...These records shall be maintained and shall be readily available for the lifespan of the equipment or for any time period required by national, regional and local regulations.<br /><strong>ISO 15189: 5.3.4</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_obsoEquiPro = Note::create(array("name" => "Obsolete Equipment Procedures", "description" => "<i><small><strong>Standard:</strong> The laboratory must have procedures for proper retirement of obsolete equipment and should be removed from the laboratory to free work and storage areas. The equipment shall be properly decontaminated before being removed from the lab<br /><strong>ISO 15189: 5.3.7</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipCalibPro = Note::create(array("name" => "Adherence to Equipment Calibration Protocol", "description" => "<i><small><strong>Standard:</strong> All equipment in the laboratory that require calibration must be calibrated according to the schedule, which at minimum must meet the manufacturer's recommendations. This shall cover major analyzers as well as ancillary equipments like pipettes, thermometers, balances, centrifuges, timers, balances<br /><strong>ISO 15189: 4.2.5, 5.3.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipPreMain = Note::create(array("name" => "Equipment Preventive Maintenance", "description" => "<i><small><strong>Standard:</strong> Preventative maintenance by operators must be done on all equipment used in examinations including centrifuges, autoclaves, microscopes, safety cabinets<br /><strong>ISO 15189: 4.2.5, 5.3.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipSerMain = Note::create(array("name" => "Equipment Service Maintenance", "description" => "<i><small><strong>Standard:</strong> All equipments must be serviced at specified intervals by a qualified service engineer either through service contracts or otherwise. Service schedule must at minimum meet manufactures requirements<br /><strong>ISO 15189: 4.2.5, 5.3.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipPartsRep = Note::create(array("name" => "Equipment Parts for Repair", "description" => "<i><small><strong>Standard:</strong> \"Equipment shall be shown (upon installation and in routine use) to be capable of achieving the performance required and shall comply with specifications relevant to the examinations concerned.\"<br /><strong>ISO 15189: 5.3.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipMalf = Note::create(array("name" => "Equipment Malfunction - Response and Documentation", "description" => "<i><small><strong>Standard:</strong> All equipment malfunctions must be investigated and documented on corrective action reports. Where user cannot resolve the problem, a repair order must be initiated<br /><strong>ISO 15189: 5.3.7, 4.9</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipRepair = Note::create(array("name" => "Equipment Repair Monitoring and Documentation", "description" => "<i><small><strong>Standard:</strong> All equipment should receive thorough documented checks to ensure proper functioning before being returned into service, following its absence from the laboratory.<br /><strong>ISO 15189: 5.3.10</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_equipFailure = Note::create(array("name" => "Equipment Failure - Contingency Plan", "description" => "<i><small><strong>Standard:</strong> Contingency plans must be in place, in the event of equipment failure, for the completion of testing. In the event of a testing disruption, planning may include the use of a back-up instrument, the use of a different testing method, the referral of samples to another laboratory, or the freezing of samples until testing is reestablished.<br /><strong>ISO 15189: 5.3.1</strong> \"The laboratory shall be furnished with all items of equipment required for the provision of services (including primary sample collection, and sample preparation and processing, examination and storage). In those cases where the laboratory needs to use equipment outside its permanent control, laboratory management shall ensure that the requirements of this international Standard are met.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_manOpManual = Note::create(array("name" => "Manufacturer’s Operator Manual", "description" => "<i><small><strong>Standard:</strong> Operator manuals must be readily available for reference by testing staff.<br /><strong>ISO 15189: 5.3.5</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_commEff = Note::create(array("name" => "Communication on Effectiveness of Quality Management System", "description" => "<i><small><strong>Standard:</strong> Laboratory management shall ensure that appropriate communication processes are established within the laboratory and that communication takes place regarding the effectiveness of the quality management system.<br /><strong>ISO 15189: 4.1.6</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 6
        $note_internalAudits = Note::create(array("name" => "Internal Audits", "description" => "<i><small><strong>Standard:</strong> Internal audits should be conducted at least annually. Investigation of individual problems may not reveal trends or patterns. Errors and incident reports should be reviewed periodically to determine whether systemic problems are responsible for errors and/or incidents. Laboratory management shall monitor the results of any corrective action taken, in order to ensure that they have been effective in overcoming the identified problems.<br /><strong>ISO 15189: 4.2.4, 4.10.3, 4.14</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 7
        $note_invBudgetSys = Note::create(array("name" => "Inventory and Budgeting System", "description" => "<i><small><strong>Standard:</strong> The Laboratory must have a systematic way of determining its supply and testing needs through inventory control and budgeting systems that take into consideration past patterns, present trends, and future plans.<br /><strong>ISO 15189: 4.6.4</strong> \"The laboratory shall evaluate suppliers of critical reagents, supplies and services that affect the quality of examinations and shall maintain records of these evaluations and list those approved.\" <strong>ISO 15189: 5.1.4 (i)</strong> \"Provide effective and efficient administration of the medical laboratory service, including budget planning and control with responsible financial management.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_suppPerfRev = Note::create(array("name" => "Service Supplier Performance Review", "description" => "<i><small><strong>Standard:</strong> All suppliers of services used by the laboratory must be reviewed for their performance. Those that perform well must be identified and listed as approved suppliers. Results of these reviews must be documented<br /><strong>ISO 15189: 4.6.4</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_manSuppList = Note::create(array("name" => "Manufacturer/Supplier List", "description" => "<i><small><strong>Standard:</strong> Each laboratory should keep a comprehensive and up-to-date list of approved manufacturers/suppliers that includes full contact details to expedite ordering, tracking, and follow-up.<br /><strong>ISO 15189: 4.6.4</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_budgetaryPro = Note::create(array("name" => "Budgetary Projections", "description" => "<i><small><strong>Standard: ISO 15189: 5.1.4 (i)</strong> \"Provide effective and efficient administration of the medical laboratory service, including budget planning and control with responsible financial management.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_orderTrack = Note::create(array("name" => "Order Tracking, Inspection, and Documentation", "description" => "<i><small><strong>Standard:</strong> All incoming orders should be inspected for condition and completeness, receipted and documented appropriately and the date received in the laboratory and the expiry date for the product should be clearly indicated.<br /><strong>ISO 15189: 4.6.1 and 4.6.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_invControlSys = Note::create(array("name" => "Inventory Control System", "description" => "<i><small><strong>Standard:</strong> There laboratory shall have an inventory control system for supplies that monitors receipt, storage and use of consumables<br /><strong>ISO 15189: 4.6.1, 4.6.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labInvSys = Note::create(array("name" => "Laboratory Inventory System", "description" => "<i><small><strong>Standard:</strong> The Laboratory inventory system shall reliably inform the Laboratory of how much at minimum must be kept in the laboratory to avoid interruption of service due to stock outs and how much at maximum must be kept by the lab to prevent expiry of reagents<br /><strong>ISO 15189: 4.6.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_usageRateTrack = Note::create(array("name" => "Usage Rate Tracking of Consumables", "description" => "<i><small><strong>Standard:</strong> The inventory control system must allow the Laboratory to track rate of usage of consumables<br /><strong>ISO 15189: 4.6.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_invStockCounts = Note::create(array("name" => "Inventory Control System – Stock Counts", "description" => "<i><small><strong>Standard:</strong> The laboratory must routinely perform stock counts as part of its inventory control system<br /><strong>ISO 15189: 4.6.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_storageArea = Note::create(array("name" => "Storage Area", "description" => "<i><small><strong>CAP Standard: Laboratory General Checklist, 2010<br />GEN 61300, 61400,61500,61600,61900,62000,62100</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_invOrg = Note::create(array("name" => "Inventory Organization and Wastage Minimization", "description" => "<i><small><strong>USAID Standard:</strong> To minimize wastage from product expiry, inventory should be organized in line with the First-Expiry-First-Out (FEFO) principle. Place products that will expire first in front of products with a later expiry date and issue stock accordingly to ensure products in use are not past their expiry date. Remember that the order in which products are received is not necessarily the order in which they will expire. <strong>USAID Deliver Project, the Logistics Handbook, Task Order 1, 2007</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_disExPro = Note::create(array("name" => "Disposal of Expired Products", "description" => "<i><small><strong>Standard:</strong> Expired products should be disposed of properly. If safe disposal is not available at the laboratory, the manufacturer/supplier should take back the expired stock at the time of their next delivery.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_proEx = Note::create(array("name" => "Product Expiration", "description" => "<i><small><strong>CAP Standard:</strong> All reagent and test kits in use, as well as those in stock, should be within the manufacturer-assigned expiry dates. Expired stock should not be entered into use and should be documented before disposal. <strong>Chemistry and Toxicology Checklist, CHM 12660, 2010</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labTestServ = Note::create(array("name" => "Laboratory Testing Services", "description" => "<i><small><strong>Standard:</strong> Testing services should not be subject to interruption due to stock outs. Laboratories should pursue all options for borrowing stock from another laboratory or referring samples to another testing facility while the stock out is being addressed.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 8
        $note_speColl = Note::create(array("name" => "Specimen collection", "description" => "<i><small><strong>Standard:</strong> \"Specific instructions for the proper collection and handling of primary samples shall be documented and implemented by laboratory management and made available to those responsible for primary sample collection.\"<br /><strong>ISO 15189: 5.4.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_sampleRecPro = Note::create(array("name" => "Adequate sample receiving procedures", "description" => "<i><small><strong>Standard: ISO 15189: 5.4.1, 5.4.5, 5.4.7, 5.4.8, 5.4.10, 5.4.11, 5.4.13</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_specStorage = Note::create(array("name" => "Specimens stored appropriately", "description" => "<i><small><strong>Standard:</strong> \"Relevant storage space and conditions shall be provided to ensure the continuing integrity of samples, slides, histology blocks, retained micro-organisms, documents, files, manuals, equipment, reagents, laboratory supplies, records and results.\" Specimens should be stored under the appropriate conditions to maintain the stability of the specimen. Specimens no longer required should be disposed of in a safe manner, according to Biosafety regulations.<br /><strong>ISO 15189: 5.2.9, 5.7.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_specPackage = Note::create(array("name" => "Specimens packaged appropriately", "description" => "<i><small><strong>Standard:</strong> All samples shall be transported to the laboratory in such a manner as to prevent contamination of workers, patients, or the environment.<br /><strong>ISO Safety Standard 15190: Clause 26</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_referredSpecTrack = Note::create(array("name" => "Referred specimens tracked properly", "description" => "<i><small><strong>Standard:</strong> \"The laboratory shall maintain a register of all referral laboratories that it uses. A register shall be kept of all samples that have been referred to another laboratory\" The referral log must be reviewed routinely for outstanding results and turnaround times<br /><strong>ISO 15189: 4.5.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_completeProcMan = Note::create(array("name" => "Complete procedure manual available", "description" => "<i><small><strong>Standard:</strong> \"All procedures shall be documented and be available at the workstation for relevant staff. Documented procedures and necessary instructions shall be available in a language commonly understood by the staff in the laboratory.\"<br /><strong>ISO 15189: 5.5.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_reagentLogbook = Note::create(array("name" => "Reagent logbook", "description" => "<i><small><strong>Standard:</strong> \"Purchased equipment and consumable supplies that affect the quality of the service shall not be used until they have been verified as complying with standard specifications or requirements defined for the procedures concerned. This may be accomplished by examining quality control samples and verifying that results are acceptable.\"<br /><strong>ISO 15189: 4.6.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_internalQC = Note::create(array("name" => "Internal quality control performed", "description" => "<i><small><strong>Standard:</strong> The laboratory shall design internal quality control systems that verify the attainment of the intended quality of results. It is important that the control system provide staff members with clear and easily understood information on which to base technical and medical decisions<br /><strong>ISO 15189: 4.2.2, 5.6.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qcResMon = Note::create(array("name" => "QC results monitored and reviewed", "description" => "<i><small><strong>Standard:</strong> \"The laboratory shall design internal quality control systems that verify the attainment of the intended quality of results.\" As part of the Laboratory internal quality control systems L-J charts shall be used to monitor quantitative tests on a daily basis and reviewed routinely.<br /><strong>ISO 15189: 5.6.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_envConCheck = Note::create(array("name" => "Environmental conditions are checked and reviewed", "description" => "<i><small><strong>Standard:</strong> \"The laboratory shall monitor, control and record environmental conditions, as required by relevant specifications or where they may influence the quality of the results.\"<br /><strong>ISO 15189: 5.2.5</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_accRanges = Note::create(array("name" => "Acceptable ranges defined", "description" => "<i><small><strong>Standard: SMILE, Johns Hopkins University, Baltimore, MD, Pro 71-07, May 20, 2010.</strong> \"Acceptable ranges or criteria must be defined, with documentation of action taken in response to out of range temperatures.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_extPT = Note::create(array("name" => "Participation in external Proficiency Testing", "description" => "<i><small><strong>Standard:</strong> The laboratory should handle, analyze, review, and report results for proficiency testing in manner similar to regular patient testing. Investigation and correction of problems identified by unacceptable proficiency testing should be documented. Acceptable results that show bias or trends suggest a problem should also be investigated.<br /><strong>ISO 15189: 4.2.2, 5.6.4, 5.6.5, 5.6.7</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_testReqCheck = Note::create(array("name" => "Test requests checked with test results", "description" => "<i><small><strong>Standard:</strong> Authorized personnel shall systematically review he results of examinations, evaluate them in conformity with the clinical information available regarding the patient and authorized the release the results. A standard procedure should be followed for cross-checking all results. In instances where there is a LIS (laboratory information system) daily printing of the pending reports list should be done routinely to cross-check the completion of all tests within the defined turnaround times.<br /><strong>ISO 15189: 5.7.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 9
        $note_testResRep = Note::create(array("name" => "Test Result Reporting System", "description" => "<i><small><strong>Standard:</strong> Results must be written in ink, written clearly with no mistakes in transcription. Cancellation must follow Good Lab Practices. The persons performing the test must indicate verification of the results. There must be signature or identification of person authorizing the release of the report.<br /><strong>ISO 15189: 5.8.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_testPersonnel = Note::create(array("name" => "Testing Personnel", "description" => "<i><small><strong>Standard:</strong> The person who performed the procedure must be identified on the report for purposes of audit trail.<br /><strong>ISO 15189: 5.4.7</strong> \"All primary samples received shall be recorded in an accession book, worksheet, computer or other comparable system. The date and time of receipt of samples, as well as the identity of the receiving officer, shall be recorded.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_testResRec = Note::create(array("name" => "Test Result Records", "description" => "<i><small><strong>Standard:</strong> In line with maintaining agreed turnaround times, the Laboratory shall perform and record test results in a timely manner and confidentiality of reported and stored result reports shall be maintained.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_analyticSys = Note::create(array("name" => "Analytic System/Method Tracing", "description" => "<i><small><strong>Standard:</strong> It is important that the laboratory has the ability to trace specimen results to a specific analytical system or method. Proficiency testing specimens would also fall under specimen results.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_resXCheckSys = Note::create(array("name" => "Result Cross-check System", "description" => "<i><small><strong>Standard:</strong> The laboratory must have a system for cross-checking of results before release to requesters in order to identify and correct errors<br /><strong>ISO 15189: 5.8.3</strong> \"Results shall be legible, without mistakes in transcription and reported to persons authorized to receive and use medical information.\"</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_archivedData = Note::create(array("name" => "Archived Data Labeling and Storage", "description" => "<i><small><strong>Standard:</strong> All patient data, paper, tapes, disks should be properly labeled and stored securely in places accessible only to authorized personnel.<br /><strong>ISO 15189: 5.8.3 Annex B 6.4.</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_infoDataBackup = Note::create(array("name" => "Information and Data Backup System", "description" => "<i><small><strong>Standard:</strong> The laboratory should have a procedure to protect essential data in the event of equipment failure and/or an unexpected destructive event. These procedures could include flood and fire safe storage of data, periodic backing up and storing of information, and off-site storage of backup data.<br /><strong>ISO 15189: 5.8.3 Annex B 3.3.</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 10
        $note_labOccurenceRep = Note::create(array("name" => "Laboratory-documented occurrence reports", "description" => "<i><small><strong>Standard:</strong> \"Laboratory shall have a policy and procedures for the resolution of complaints or other feedback received from clinicians, patients or other parties. Records of complaints and of investigations and corrective actions taken by the laboratory shall be maintained.\"<br /><strong>ISO 15189: 4.8</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_nonConfWork = Note::create(array("name" => "Non-conforming work reviewed", "description" => "<i><small><strong>Standard:</strong> \"Procedures for corrective action shall include an investigative process to determine the underlying cause or causes of the problem. These shall, where appropriate, lead to preventive actions. Corrective action shall be appropriate to the magnitude of the problem and commensurate with possible risks.\" \"The laboratory shall document, record and, as appropriate, expeditiously act upon results from these comparisons. Problems or deficiencies identified shall be acted upon and records of actions retained.\"<br /><strong>ISO 15189: 4.10.1; 5.6.7</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_corrAction = Note::create(array("name" => "Corrective action performed", "description" => "<i><small><strong>Standard:</strong> Laboratory management shall have a policy and procedure to be implemented when it detects that any aspect of its examinations does not conform with its own procedures or the agreed upon requirements of its quality management system or the requesting clinicians.<br /><strong>ISO 15189:4.9.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_discordantResTrack = Note::create(array("name" => "Discordant results tracked", "description" => "<i><small><strong>Standard:</strong> Procedures for corrective action shall include an investigative process to determine the underlying cause or causes of the problem.<br /><strong>ISO 15189: 4.10.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 11
        $note_graphTools = Note::create(array("name" => "Graphical tools", "description" => "<i><small><strong>Standard:</strong> \"Apart from the review of the operational procedures, preventive action might involve analysis of data, including trend-and risk-analyses and external quality assurance.\" Use of graphical displays of quality data communicates more effectively than tables of numbers. Examples of graphical tools commonly used for this purpose include Pareto charts, cause-and-effect diagrams, frequency histograms, trend graphs, and flow charts.<br /><strong>ISO 15189: 4.11.2 , Note 1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_qIndicators = Note::create(array("name" => "Quality indicators", "description" => "<i><small><strong>Standard:</strong> \"Laboratory management shall implement quality indicators for systematically monitoring and evaluating the laboratory's contributing These indicators should be compared against a benchmark from an acknowledged guideline.\" \"Laboratory management, in consultation with the requesters, shall establish turnaround times for each of its examinations. A turnaround time shall reflect clinical needs.\" Key indicators of quality must be monitored regularly and evaluated for opportunities to improve testing services. Indicators should be drawn from pre-analytic, analytic, and post-analytic phases and reflect activities critical to patient outcomes, those that correspond to a large proportion of the laboratory's patients, or areas that have been problematic in the past. These indicators should be compared against a benchmark from an acknowledged guideline.<br /><strong>ISO 15189: 4.12.4, 5.8.11</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        //  Section 12
        $note_sizeOfLab = Note::create(array("name" => "Size of the laboratory adequate", "description" => "<i><small><strong>Standard:</strong> The laboratory floor plan should be configured to promote high quality work, personnel safety, and efficient operations.<br /><strong>ISO 15189: 5.2.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_careNTesting = Note::create(array("name" => "Patient care and testing areas", "description" => "<i><small><strong>Standard:</strong> \"There shall be effective separation between adjacent laboratory sections in which there are incompatible activities. Measures shall be taken to prevent cross-contamination.\" Client service areas (i.e., waiting room, phlebotomy room) should be distinctly separate from the testing areas of the laboratory. Client access should not compromise 'clean' areas of the laboratory. For Biosafety reasons, microbiology and TB testing should be segregated in a separate room(s) from the general laboratory testing.<br /><strong>ISO 15189: 5.2.6</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_workStaMain = Note::create(array("name" => "Individual workstation maintained", "description" => "<i><small><strong>CAP Standard:</strong> Age-and sex-specific reference intervals (normal values) must be verified or established by laboratory. If a formal reference intervals study is not possible or practical, then the laboratory should carefully evaluate the use of published data for its own reference ranges, and retain documentation of this evaluation.<br /><strong>General Checklist, GEN.42162, 2010</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_phyWorkEnv = Note::create(array("name" => "Physical work environment appropriate", "description" => "<i><small><strong>Standard:</strong> The laboratory space should be sufficient to ensure that the quality of work, the safety of personnel, and the ability of staff to carry out quality control procedures and documentation. The laboratory should be clean and well organized, free of clutter, well ventilated, adequately lit, and within acceptable temperature ranges. \"Emergency power supply should be adequate for refrigerators, freezers, incubators, etc., to ensure preservation of patient specimens. Depending on the type of testing performed in the laboratory, emergency power may also be required for the preservation of reagents, the operation of laboratory instruments, and the functioning of the data processing system.\"<br /><strong>ISO 15189: 5.2.5 and 5.2.10 and CAP GEN.66100, General Checklist, 2010</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labSecured = Note::create(array("name" => "Laboratory properly secured from unauthorized access", "description" => "<i><small><strong>Standard:</strong> The access of unauthorized persons to the laboratory should be strictly limited to avoid the unnecessary contact of individuals with contaminated areas, reagents, or equipment. Unnecessary traffic also disturbs workflow and can distract staff members.<br /><strong>ISO 15189: 5.2.7</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labDedColdRoom = Note::create(array("name" => "Laboratory-dedicated cold and room", "description" => "<i><small><strong>Standard:</strong> Staff food items should be stored in separate locations dedicated to that purpose, not in laboratory storage areas, particularly cold storage. Laboratory reagents and blood products should be stored separately when refrigerated or frozen.<br /><strong>ISO 15190: 11.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_leakageSpills = Note::create(array("name" => "Work area clean and free of leakage & spills", "description" => "<i><small><strong>Standard:</strong> The work area should be regularly inspected for cleanliness and leakage. An appropriate disinfectant should be used. At a minimum, all bench tops and working surfaces should be disinfected at the beginning and end of every shift. All spills should be contained immediately and the work surfaces disinfected.<br /><strong>ISO 15189: 5.2.10; ISO 15190:13</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_certBiosafetyCab = Note::create(array("name" => "Certified and appropriate Biosafety cabinet", "description" => "<i><small><strong>Standard:</strong> A Biosafety cabinet should be used for to prevent aerosol exposure to contagious specimens or organisms. For proper functioning and full protection, Biosafety cabinets require periodic maintenance and should be serviced accordingly.<br /><strong>ISO 15190: 16</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_labSafetyManual = Note::create(array("name" => "Laboratory safety manual", "description" => "<i><small><strong>Standard:</strong> A safety manual shall be readily available in work areas as required reading for all employees. The manual shall be specific for the laboratory's needs. The Safety Manual shall be reviewed and updated at least annually by laboratory management.<br /><strong>ISO 15190: 7.4</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_suffWasteDisposal = Note::create(array("name" => "Sufficient waste disposal available", "description" => "<i><small><strong>Standard:</strong> Waste should be separated according to biohazard risk, with infectious and non-infectious waste disposed of in separate containers. Infectious waste should be discarded into containers that do not leak and are clearly marked with a biohazard symbol. Sharp instruments and needles should be discarded in puncture resistant containers. Both infectious waste and sharps containers should be autoclaved before being discarded to decontaminate potentially infectious material. To prevent injury from exposed waste, infectious waste should be incinerated, burnt in a pit, or buried.<br /><strong>ISO 15190:22</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_hazardousChem = Note::create(array("name" => "Hazardous chemicals / materials properly handled", "description" => "<i><small><strong>Standard:</strong> All hazardous chemicals must be labeled with the chemical's name with hazard markings clearly indicated. Flammable chemicals must be stored out of sunlight and below their flashpoint, preferably in a still cabinet in a well-ventilated area. Flammable and corrosive agents should be separated from one another. Distinct care should always be taken to handle hazardous chemicals safety in the workplace.<br /><strong>ISO 15190: 17.1 and 17.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_sharpsDisposed = Note::create(array("name" => "'Sharps' handled and disposed of properly", "description" => "<i><small><strong>Standard:</strong> All syringes, needles, lancets, or other bloodletting devices capable of transmitting infection must be used only once and discarded in puncture resistant containers that are not overfilled. Sharps containers should be clearly marked to warn handlers of the potential hazard and should be located in areas where sharps are commonly used.<br /><strong>ISO 15189: 5.2.10;CAP GEN.773100, General Checklist, 2010</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_fireSafety = Note::create(array("name" => "Fire safety included in overall safety program", "description" => "<i><small><strong>Standard:</strong> Electrical chords and plugs, power-strips, and receptacles should be maintained in good condition and utilized appropriately. Overcrowding should be avoided and chords should be kept out of walkway areas. An approved fire extinguisher should be easily accessible within the laboratory and be routinely inspected and documented for readiness. Fire extinguishers should be kept in their assigned place, not be hidden or blocked, the pin and seal should be intact, nozzles should be free of blockage, pressure gauges should show adequate pressure, and there should be no visible signs of damage. A fire alarm should be installed in the laboratory and tested regularly for readiness and all staff should participate in periodic fire drills.</small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_inspAudReg = Note::create(array("name" => "Safety inspections or audits conducted regularly", "description" => "<i><small><strong>Standard:</strong> Safety inspections or audits, using a safety checklist, should be conducted periodically to ensure the laboratory is a safe work environment and identify areas for redress and correction.<br /><strong>ISO 15190 7.3.1 and 7.3.2</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_stdSafetyEqui = Note::create(array("name" => "Standard safety equipment available", "description" => "<i><small><strong>Standard:</strong> It is the responsibility of laboratory management to ensure the laboratory is equipped with standard safety equipment. The list above is a partial list of necessary items. Biosafety cabinets should be in place and in use and all centrifuges should have covers. Hand washing stations should be designated and equipped and eyewash stations (or an acceptable alternative method of eye cleansing) should be available and operable. Spill kits and first aid kits should be kept in a designated place and checked regularly for readiness.<br /><strong>ISO 15190: 5.1</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_personalProEqui = Note::create(array("name" => "Personal protective equipment", "description" => "<i><small><strong>Standard:</strong> Management is responsible to provide appropriate personal protective equipment—gloves, lab coats, eye protection, etc.--in useable condition. Laboratory staff must utilize personal protective equipment in the laboratory at all times. Protective clothing should not be worn outside the laboratory. Gloves should be replaced immediately when torn or contaminated and not washed for reuse.<br /><strong>ISO 15190: 12</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_vaccPrevMeasures = Note::create(array("name" => "Appropriate vaccination/preventive measures", "description" => "<i><small><strong>Standard:</strong> Laboratory staff should be offered appropriate vaccinations--particularly Hepatitis B. Staff may decline to receive the vaccination, but should sign a declination form to be held in the staff member's personnel file.<br /><strong>ISO 15190: 11.3</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_postExProphy = Note::create(array("name" => "Post-exposure prophylaxis policies and procedures", "description" => "<i><small><strong>Standard:</strong> The laboratory must have a procedure for follow-up of possible and known percutaneous, mucus membrane, or abraded skin exposure to HIV, HBV, or HCV. The procedure should include clinical and serological evaluation and appropriate prophylaxis.<br /><strong>ISO 15190: 9</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_occInjuries = Note::create(array("name" => "Occupational injuries documented", "description" => "<i><small><strong>Standard:</strong> All occupational injuries or illnesses should be thoroughly investigated and documented in the safety log or occurrence log, depending on the laboratory. Corrective actions taken by the laboratory in response to an accident or injury must also be documented.<br /><strong>ISO 15190: 9</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_workersTraBiosafety = Note::create(array("name" => "Drivers/couriers and cleaners trained in Biosafety ", "description" => "<i><small><strong>Standard:</strong> All occupational injuries or illnesses should be thoroughly investigated and documented in the safety log or occurrence log, depending on the laboratory. Corrective actions taken by the laboratory in response to an accident or injury must also be documented.<br /><strong>ISO 15190: 10</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        $note_trainedSafetyOfficer = Note::create(array("name" => "Trained safety officer for safety program", "description" => "<i><small><strong>Standard:</strong> A safety officer should be designated to work with the laboratory manager to implement the safety program, monitor the ongoing safety conditions and needs of the laboratory, coordinate safety training, and serve as a resource for other staff. This officer should receive safety training.<br /><strong>ISO 15190: 7,10</strong></small></i>", "audit_type_id" => "1", "user_id" => "1"));
        
        $this->command->info('Notes table seeded');

        /* Sections */
        $sec_mainPage = Section::create(array("name" => "Main Page", "label" => "1.0 INTRODUCTION", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_part1 = Section::create(array("name" => "Part I", "label" => "Part I", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_slmtaInfo = Section::create(array("name" => "SLMTA Info", "label" => "SLMTA Information", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_mainPage->id, "user_id" => "1"));
        $sec_labProfile = Section::create(array("name" => "Lab Profile", "label" => "Laboratory Profile", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_labInfo = Section::create(array("name" => "Lab Info", "label" => "Lab Information", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_slmtaInfo->id, "user_id" => "1"));
        $sec_staffSummary = Section::create(array("name" => "Staffing Summary", "label" => "Staffing Summary", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_labInfo->id, "user_id" => "1"));
        $sec_orgStructure = Section::create(array("name" => "Org Structure", "label" => "Organizational Structure", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_staffSummary->id, "user_id" => "1"));
        $sec_part2 = Section::create(array("name" => "Part II", "label" => "Part II", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_prelude = Section::create(array("name" => "Prelude", "label" => "PART II: LABORATORY AUDITS", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_orgStructure->id, "user_id" => "1"));
        $sec_sec1 = Section::create(array("name" => "Section 1", "label" => "1.0 DOCUMENTS AND RECORDS", "description" => "", "audit_type_id" => "1", "total_points" => "25", "order" => $sec_prelude->id, "user_id" => "1"));
        $sec_sec2 = Section::create(array("name" => "Section 2", "label" => "2.0 MANAGEMENT REVIEWS", "description" => "", "audit_type_id" => "1", "total_points" => "17", "order" => $sec_sec1->id, "user_id" => "1"));
        $sec_sec3 = Section::create(array("name" => "Section 3", "label" => "3.0 ORGANIZATION & PERSONNEL", "description" => "", "audit_type_id" => "1", "total_points" => "20", "order" => $sec_sec2->id, "user_id" => "1"));
        $sec_sec4 = Section::create(array("name" => "Section 4", "label" => "4.0 CLIENT MANAGEMENT & CUSTOMER SERVICE", "description" => "", "audit_type_id" => "1", "total_points" => "8", "order" => $sec_sec3->id, "user_id" => "1"));
        $sec_sec5 = Section::create(array("name" => "Section 5", "label" => "5.0 EQUIPMENT", "description" => "", "audit_type_id" => "1", "total_points" => "30", "order" => $sec_sec4->id, "user_id" => "1"));
        $sec_sec6 = Section::create(array("name" => "Section 6", "label" => "6.0 INTERNAL AUDIT", "description" => "", "audit_type_id" => "1", "total_points" => "10", "order" => $sec_sec5->id, "user_id" => "1"));
        $sec_sec7 = Section::create(array("name" => "Section 7", "label" => "7.0 PURCHASING & INVENTORY", "description" => "", "audit_type_id" => "1", "total_points" => "30", "order" => $sec_sec6->id, "user_id" => "1"));
        $sec_sec8 = Section::create(array("name" => "Section 8", "label" => "8.0 PROCESS CONTROL AND INTERNAL & EXTERNAL QUALITY AUDIT", "description" => "", "audit_type_id" => "1", "total_points" => "33", "order" => $sec_sec7->id, "user_id" => "1"));
        $sec_sec9 = Section::create(array("name" => "Section 9", "label" => "9.0 INFORMATION MANAGEMENT", "description" => "", "audit_type_id" => "1", "total_points" => "18", "order" => $sec_sec8->id, "user_id" => "1"));
        $sec_sec10 = Section::create(array("name" => "Section 10", "label" => "10.0 CORRECTIVE ACTION", "description" => "", "audit_type_id" => "1", "total_points" => "12", "order" => $sec_sec9->id, "user_id" => "1"));
        $sec_sec11 = Section::create(array("name" => "Section 11", "label" => "11.0 OCCURRENCE / INCIDENT MANAGEMENT & PROCESS IMPROVEMENT", "description" => "", "audit_type_id" => "1", "total_points" => "12", "order" => $sec_sec10->id, "user_id" => "1"));
        $sec_sec12 = Section::create(array("name" => "Section 12", "label" => "12.0 FACILITIES & SAFETY", "description" => "", "audit_type_id" => "1", "total_points" => "43", "order" => $sec_sec11->id, "user_id" => "1"));
        $sec_ethicalP = Section::create(array("name" => "Ethical Principles", "label" => "ETHICAL PRINCIPLES IN LABORATORY MEDICINE", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_sec12->id, "user_id" => "1"));
        $sec_criteria1 = Section::create(array("name" => "Criteria 1", "label" => "Criteria 1", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_ethicalP->id, "user_id" => "1"));
        $sec_criteria2 = Section::create(array("name" => "Criteria 2", "label" => "Criteria 2", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_criteria1->id, "user_id" => "1"));
        $sec_part3 = Section::create(array("name" => "Part III", "label" => "Part III", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => 0, "user_id" => "1"));
        $sec_summary = Section::create(array("name" => "Summary", "label" => "PART III: SUMMARY OF AUDIT FINDINGS", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_criteria2->id, "user_id" => "1"));
        $sec_actionP = Section::create(array("name" => "Action Plan", "label" => "ACTION PLAN (IF APPLICABLE)", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_summary->id, "user_id" => "1"));
        $sec_sliptaCert = Section::create(array("name" => "SLIPTA Certification", "label" => "Criteria for SLIPTA 5 star certification and accreditation of international standards)", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_actionP->id, "user_id" => "1"));
        $this->command->info('Sections table seeded');

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
            array("section_id" => $sec_orgStructure->id, "parent_id" => $sec_labProfile->id));
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
            array("section_id" => $sec_ethicalP->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_criteria1->id, "parent_id" => $sec_part2->id));
        DB::table('section_parent_child')->insert(
            array("section_id" => $sec_criteria2->id, "parent_id" => $sec_part2->id));
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
            array("section_id" => $sec_ethicalP->id, "note_id" => $note_ethical->id));
        DB::table('section_notes')->insert(
            array("section_id" => $sec_sliptaCert->id, "note_id" => $note_certification->id));
        $this->command->info('Section-Note table seeded');
    }
}