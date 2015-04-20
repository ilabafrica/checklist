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
use App\Models\Lab;
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

        /* Laboratories */
        $labs = array(
            array("facility_id" => "3", "lab_type_id" => "1", "lab_level_id" => "3", "lab_affiliation_id" => "1", "user_id" => "1")
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
        $answer_daily = Answer::create(array("name" => "Daily", "description" => "", "user_id" => "1"));
        $answer_weekly = Answer::create(array("name" => "Weekly", "description" => "", "user_id" => "1"));
        $answer_everyRun = Answer::create(array("name" => "W/Every Run", "description" => "With Every Run", "user_id" => "1"));
        
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
        $sec_staffSummary = Section::create(array("name" => "Staffing Summary", "label" => "Laboratory Staffing Summary", "description" => "", "audit_type_id" => "1", "total_points" => "0", "order" => $sec_labInfo->id, "user_id" => "1"));
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

        /* Questions */
        //  Section 1 - Documents and Records
        $question_labQManual = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Quality Manual", "title" => "1.1 Laboratory Quality Manual", "description" => "Is there a current laboratory quality manual, composed of the quality management system’s policies and procedures, and has the manual content been communicated to and understood and implemented by all staff?", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 4.2.3, 4.2.4", "comment" => "", "score" => "4", "one_star" => "", "user_id" => "1"));
        $question_labQStructure = Question::create(array("section_id" => $sec_sec1->id, "name" => "Structure defined per ISO15189", "title" => "", "description" => "1.1.1 Structure defined per ISO15189, Section 4.2.4", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labQPolicy = Question::create(array("section_id" => $sec_sec1->id, "name" => "Quality policy statement", "title" => "", "description" => "1.1.2 Quality policy statement that includes scope of service, standard of service, objectives of the quality management system, and management commitment to compliance", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labQMS = Question::create(array("section_id" => $sec_sec1->id, "name" => "Lab QMS Structure", "title" => "", "description" => "1.1.3 Description of the quality management system and the structure of its documentation", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labSProcedures = Question::create(array("section_id" =>$sec_sec1->id, "name" => "Lab Supporting Procedures", "title" => "", "description" => "1.1.4 Reference to supporting procedures, including technical procedures", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labRoles = Question::create(array("section_id" => $sec_sec1->id, "name" => "Description of Lab Roles and Responsibilities", "title" => "", "description" => "1.1.5 Description of the roles and responsibilities of the laboratory manager, quality manager, and other personnel responsible for ensuring compliance", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labDocManReview = Question::create(array("section_id" => $sec_sec1->id, "name" => "Documentation of Annual Review", "title" => "", "description" => "1.1.6 Documentation of at least annual management review and approval.", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_docInfoCon = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document and Information Control System", "title" => "1.2 Document and Information Control System", "description" => "Does the laboratory have a system in place to control all documents and information (internal and external sources)?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_docRecords = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document and Records", "title" => "1.3 Document and Records", "description" => "Are documents and records properly maintained, easily accessible and fully detailed in an up-to-date Master List?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_poSops = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Policies and Standard Operating Procedures", "title" => "1.4 Laboratory Policies and Standard Operating Procedures", "description" => "Are policies and standard operating procedures (SOPs) for laboratory functions current, available and approved by authorized personnel?", "question_type" => "0", "required" => "1", "info" => "ISO 15189 4.3.2", "comment" => "", "score" => "5", "one_star" => "", "user_id" => "1"));
        $question_docRecControl = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document & Record Control", "title" => "1.4.1 Document & Record Control", "description" => "Defines the writing, checking, authorization, review, identification, amendments, control & communication of revisions to and retention & safe disposal of all documents and records", "question_type" => "0", "required" => "1", "info" => "Standard ISO15189: 4.3.1, 4.13.1-3", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_confOfInterest = Question::create(array("section_id" => $sec_sec1->id, "name" => "Conflict of Interest", "title" => "1.4.2 Conflict of Interest", "description" => "Defines the systems in place to identify and avoid potential conflicts of interest and commercial, financial, political or other pressures that may affect the quality and integrity of operations", "question_type" => "0", "required" => "1", "info" => "Standard: ISO15189: 4.1", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_communication = Question::create(array("section_id" => $sec_sec1->id, "name" => "Communication", "title" => "1.4.3 Communication", "description" => "Defines the systems in place to ensure effectiveness of the quality management systems", "question_type" => "0", "required" => "1", "info" => "ISO15189: 4.1.6", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_revOfContracts = Question::create(array("section_id" => $sec_sec1->id, "name" => "Review of Contracts", "title" => "1.4.4 Review of Contracts (Supplier and Customer)", "description" => "Defines the maintenance of all records, original requests, inquiries, verbal discussions and requests for additional examinations, meetings, and meeting minutes.", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.4", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_referralExam = Question::create(array("section_id" => $sec_sec1->id, "name" => "Examination by Referral Laboratories", "title" => "1.4.5 Examination by Referral Laboratories", "description" => "Defines the 1) evaluation, selection, and performance monitoring of referral laboratories, 2) packaging and tracking of referred samples, 3) and reporting of results from referral labs", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.5.1", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_purInvCon = Question::create(array("section_id" => $sec_sec1->id, "name" => "Purchasing and Inventory Control", "title" => "1.4.6 Purchasing and Inventory Control", "description" => "Defines the processes for 1) requesting, ordering and receipt of supplies, 2) the selection of approved suppliers, 3) acceptance/rejection criteria for purchased items, 4) safe handling; 5) storage; inventory control system; 6) monitoring and handling of expired consumables", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.6", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_advisory = Question::create(array("section_id" => $sec_sec1->id, "name" => "Advisory Services", "title" => "1.4.7 Advisory Services", "description" => "Defines the required qualifications and responsibility for providing advice on: 1) choice of examinations; 2) the use of the services; 3) repeat frequency; 4) required type of sample; 5) interpretation of results; and 6) maintenance of records of communication with lab users", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 4.7", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_compFeedback = Question::create(array("section_id" => $sec_sec1->id, "name" => "Resolution of Complaints and Feedback", "title" => "1.4.8 Resolution of Complaints and Feedback", "description" => "Defines how 1) complaints and feedback shall be recorded, 2) steps to determine whether patient’s results have been compromised, 3) investigative and corrective actions taken as required, 4) timeframe for closure and feedback to the complainant", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.8", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_nonConformities = Question::create(array("section_id" => $sec_sec1->id, "name" => "Identification and Control of Nonconformities", "title" => "1.4.9 Identification and Control of Nonconformities", "description" => "Defines the 1) types of nonconformities that could be identified, 2) how/where to record, 3) who is responsible for problem resolution; 4) when examinations are to be halted, 5) the recall of released results and 6) person responsible for authorizing release of results after corrective action has been taken", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.9", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_corrAction = Question::create(array("section_id" => $sec_sec1->id, "name" => "Corrective Action", "title" => "1.4.10 Corrective Action", "description" => "Defines 1) where to record, 2) how to perform root cause analysis, 3) who will be responsible for implementing action plans within the stipulated timeframes, and 4) monitoring the effectiveness of these actions in overcoming the identified problems.", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.10", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_prevAction = Question::create(array("section_id" => $sec_sec1->id, "name" => "Preventive Action", "title" => "1.4.11 Preventive Action", "description" => "Defines what tools will be used, where the action plan will be recorded, who will be responsible for ensuring the implementation within an agreed time frame and the monitoring of its effectiveness", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.11", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_contImpro = Question::create(array("section_id" => $sec_sec1->id, "name" => "Continual Improvement", "title" => "1.4.12 Continual Improvement", "description" => "Defines what quality indicators will be used and how action plans for these areas will be recorded, evaluated, and reviewed for effectiveness of improvement", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.12", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_quaTechRec = Question::create(array("section_id" => $sec_sec1->id, "name" => "Quality and Technical Records", "title" => "1.4.13 Quality and Technical Records", "description" => "Defines what are quality and technical records, how amendments would be done, traceability, storage, retention and accessibility of all hard and electronic records", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.13", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_inAudits = Question::create(array("section_id" => $sec_sec1->id, "name" => "Internal Audits", "title" => "1.4.14 Internal Audits", "description" => "Defines the internal audit process, including roles and responsibilities, types of audits, frequency of audits, auditing forms to be used, what will be covered, and identification of personnel responsible for ensuring closure of any nonconformances raised within the agreed timeframe and effectiveness of corrective actions implemented.", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.14", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_manReview = Question::create(array("section_id" => $sec_sec1->id, "name" => "Management Review", "title" => "1.4.15 Management Review", "description" => "Defines frequency, agenda (in line with 4.15.2 a-m), key attendees required, and plan that will include goals, objectives, action plans, responsibilities, due dates and how decisions/actions taken will be communicated to the relevant persons", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 4.15", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_persFiles = Question::create(array("section_id" => $sec_sec1->id, "name" => "Personnel Records/Files", "title" => "1.4.16 Personnel Records/Files", "description" => "Defines organizational plan, personnel policies, what is required in a personnel file (minimum in line with ISO 15189 Section 5.1.2) and location of personnel files", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 5.1", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_persTraining = Question::create(array("section_id" => $sec_sec1->id, "name" => "Personnel Training", "title" => "1.4.17 Personnel Training", "description" => "Defines staff appraisals, staff orientation, initial training, refresher training, continuous education program, recommended and required trainings, and record-keeping of training", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 5.1.4, 5.1.6, 5.1.9", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_competencyAudit = Question::create(array("section_id" => $sec_sec1->id, "name" => "Competency audit", "title" => "1.4.18 Competency audit", "description" => "Defines the methods, ongoing competency testing and training, and criteria used to assess competency of personnel", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 5.1.11", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_Auth = Question::create(array("section_id" => $sec_sec1->id, "name" => "Authorization", "title" => "1.4.19 Authorization", "description" => "Defines the level of authorization for all tasks, roles and deputies for all staff", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 5.1.7", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_Accomo = Question::create(array("section_id" => $sec_sec1->id, "name" => "Accommodation and Environmental Conditions", "title" => "1.4.20 Accommodation and Environmental Conditions", "description" => "Defines any specific environmental and accommodation requirements, and the responsibility, monitoring, controlling, and recording of these requirements.", "question_type" => "0", "required" => "1", "info" => "Standard: ISO 15189: 5.2.5", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_Equip = Question::create(array("section_id" => $sec_sec1->id, "name" => "Equipment", "title" => "1.4.21 Equipment", "description" => "Defines what records are to be maintained in equipment file, the minimum information required on equipment label; action to be taken for defective equipment and maintenance frequency; and access control", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_EquiCalib = Question::create(array("section_id" => $sec_sec1->id, "name" => "Calibration of Equipment", "title" => "1.4.22 Calibration of Equipment", "description" => "Defines frequency; the use of reference standards where applicable; what is required on the calibration label or calibration record and what action to be taken if calibration fails", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.3", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_preExamPro = Question::create(array("section_id" => $sec_sec1->id, "name" => "Pre-examination Procedures", "title" => "1.4.23 Pre-examination Procedures (Handbook)", "description" => "Defines Specimen Collection, sample and volume requirements; unique identification, special handling; minimum requirements for completion of a requisition form, transportation and receipt of samples", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.4.2,5.4.3", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_speStoRe = Question::create(array("section_id" => $sec_sec1->id, "name" => "Specimen Storage and Retention", "title" => "1.4.24 Specimen Storage and Retention", "description" => "Defines pre- and post-sampling storage conditions, stability and retention times", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.7.2", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_exSops = Question::create(array("section_id" => $sec_sec1->id, "name" => "Examination SOPs", "title" => "1.4.25 Examination SOPs", "description" => "Defines all sub-clauses of ISO15189 Section 5.5.3 (a-q)", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.5.3", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_equiVal = Question::create(array("section_id" => $sec_sec1->id, "name" => "Equipment Validation", "title" => "1.4.26 Equipment Validation/Verification", "description" => "Defines methods to be used, how the lab ensures that equipment taken out of the control from the lab is checked and shown to be functioning satisfactorily before being returned to laboratory use, validation/verification acceptance criteria and person responsible for final authorization for intended use", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.5.2", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_interSer = Question::create(array("section_id" => $sec_sec1->id, "name" => "Interrupted Services", "title" => "1.4.27 Interrupted Services", "description" => "Defines backup procedures for equipment failure, power failure, unavailability of consumables and other resources", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_exVal = Question::create(array("section_id" => $sec_sec1->id, "name" => "Examination Validation", "title" => "1.4.28 Examination Validation/Verification", "description" => "Defines methods to be used, acceptance criteria, and person responsible for final authorization for intended use", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.5.2", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_quaAssurance = Question::create(array("section_id" => $sec_sec1->id, "name" => "Quality Assurance", "title" => "1.4.29 Quality Assurance", "description" => "Defines the use of IQC and EQC, setting up of ranges, monitoring performance and troubleshooting guidelines", "question_type" => "0", "required" => "1", "info" => "ISO 15189 5.6", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_resRep = Question::create(array("section_id" => $sec_sec1->id, "name" => "Reporting of Results", "title" => "1.4.30 Reporting of Results", "description" => "Defines the standardized format of a report (in line with ISO15189: Section 5.8.3), methods of communication, release of results to authorized persons, alteration of reports and reissuance of amended reports.", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.8", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_patConf = Question::create(array("section_id" => $sec_sec1->id, "name" => "Patient Confidentiality", "title" => "1.4.31 Patient Confidentiality", "description" => "Defines the tools used to ensure patient confidentiality and access control to laboratory facilities and records (electronic and paper records)", "question_type" => "0", "required" => "1", "info" => "ISO 15189: 5.8.13", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labSafeMan = Question::create(array("section_id" => $sec_sec1->id, "name" => "Laboratory Safety or Safety Manual", "title" => "1.4.32 Laboratory Safety or Safety Manual", "description" => "Defines the contents to be included.", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 7.5", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_poSopsA = Question::create(array("section_id" => $sec_sec1->id, "name" => "Policy and SOPs Accessibility", "title" => "1.5 Policy and SOPs Accessibility", "description" => "Are policies and SOPs easily accessible/ available to all staff and written in a language commonly understood by respective staff?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_poSopsComm = Question::create(array("section_id" => $sec_sec1->id, "name" => "Policies and SOPs Communication", "title" => "1.6 Policies and SOPs Communication", "description" => "Is there documented evidence that all relevant policies and SOPs have been communicated to and are understood and implemented by all staff as related to their responsibilities?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_docConLog = Question::create(array("section_id" => $sec_sec1->id, "name" => "Document Control Log", "title" => "1.7 Document Control Log", "description" => "Are policies and procedures dated to reflect when it was put into effect and when it was discontinued?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_discPoSops = Question::create(array("section_id" => $sec_sec1->id, "name" => "Discontinued Policies and SOPs", "title" => "1.8 Discontinued Policies and SOPs", "description" => "Are invalid or discontinued policies and procedures removed from use and retained or archived for the time period required by lab and/or national policy?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_dataFiles = Question::create(array("section_id" => $sec_sec1->id, "name" => "Data Files", "title" => "1.9 Data Files", "description" => "Are test results and technical and quality records archived in accordance with national/international guidelines?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_arcResA = Question::create(array("section_id" => $sec_sec1->id, "name" => "Archived Results Accessibility", "title" => "1.10 Archived Results Accessibility", "description" => "Are archived records and results easily retrievable in a timely manner?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 2 - Management Review
        $question_workBudget = Question::create(array("section_id" => $sec_sec2->id, "name" => "Workplan and Budget", "title" => "2.1 Workplan and Budget", "description" => "Does management develop and implement a workplan and develop a budget that supports the laboratory’s testing operations and maintenance of the quality system?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_quaTechRecRev = Question::create(array("section_id" => $sec_sec2->id, "name" => "Review of Quality and Technical Records", "title" => "2.2 Review of Quality and Technical Records", "description" => "Does the laboratory supervisor routinely perform a documented review of all quality and technical records?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "5", "one_star" => "", "user_id" => "1"));
        $question_prevActItems = Question::create(array("section_id" => $sec_sec2->id, "name" => "Follow-up of action items from previous reviews", "title" => "", "description" => "2.2.1 Follow-up of action items from previous reviews", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_corrActStatus = Question::create(array("section_id" => $sec_sec2->id, "name" => "Status of corrective actions taken", "title" => "", "description" => "2.2.2 Status of corrective actions taken and required preventive actions", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_repFromPersonnel = Question::create(array("section_id" => $sec_sec2->id, "name" => "Reports from personnel", "title" => "", "description" => "2.2.3 Reports from personnel", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_workVolChange = Question::create(array("section_id" => $sec_sec2->id, "name" => "Changes in volume and type of work", "title" => "", "description" => "2.2.4 Changes in volume and type of work the laboratory undertakes", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_bioRefRangeChange = Question::create(array("section_id" => $sec_sec2->id, "name" => "Changes in the suitability of biological reference ranges", "title" => "", "description" => "2.2.5 Changes in the suitability of biological reference ranges", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_cliHandbook = Question::create(array("section_id" => $sec_sec2->id, "name" => "Changes in the client handbook", "title" => "", "description" => "2.2.6 Changes in the client handbook", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_envMonLog = Question::create(array("section_id" => $sec_sec2->id, "name" => "Environmental monitoring log sheets", "title" => "", "description" => "2.2.7 Environmental monitoring log sheets", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_speRejLog = Question::create(array("section_id" => $sec_sec2->id, "name" => "Specimen rejection logbook", "title" => "", "description" => "2.2.8 Specimen rejection logbook", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_equiCalibManRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Equipment calibration and maintenance records", "title" => "", "description" => "2.2.9 Equipment calibration and maintenance records", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_iqcRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "IQC records across all test areas", "title" => "", "description" => "2.2.10 IQC records across all test areas", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ptIntLabCo = Question::create(array("section_id" => $sec_sec2->id, "name" => "PTs and other forms of Inter-laboratory comparisons", "title" => "", "description" => "2.2.11 Outcomes of PTs and other forms of Inter-laboratory comparisons", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_tatMon = Question::create(array("section_id" => $sec_sec2->id, "name" => "Monitoring of turnaround time", "title" => "", "description" => "2.2.12 Monitoring of turnaround time", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_qInd = Question::create(array("section_id" => $sec_sec2->id, "name" => "Quality indicators", "title" => "", "description" => "2.2.13 Quality indicators", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_recentIntAudRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Outcomes from recent internal audit records", "title" => "", "description" => "2.2.14 Outcomes from recent internal audit records", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_extAudRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Results of audit(s) or audits by external bodies", "title" => "", "description" => "2.2.15 Results of audit(s) or audits by external bodies", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_custCompFeed = Question::create(array("section_id" => $sec_sec2->id, "name" => "Customer complaints and feedback", "title" => "", "description" => "2.2.16 Customer complaints and feedback", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_occIncLogs = Question::create(array("section_id" => $sec_sec2->id, "name" => "Occurrence/incidence logs", "title" => "", "description" => "2.2.17 Occurrence/incidence logs, nonconformities and corrective action reports", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_impProRes = Question::create(array("section_id" => $sec_sec2->id, "name" => "Results of improvement projects", "title" => "", "description" => "2.2.18 Results of improvement projects", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_operPro = Question::create(array("section_id" => $sec_sec2->id, "name" => "Operational procedures", "title" => "", "description" => "2.2.19 Operational procedures (for potential sources of non-conformance and opportunities for improvement)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_refLabPerfEval = Question::create(array("section_id" => $sec_sec2->id, "name" => "Evaluation of performance of referral laboratories", "title" => "", "description" => "2.2.20 Evaluation of performance of referral laboratories", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_suppPerfEval = Question::create(array("section_id" => $sec_sec2->id, "name" => "Evaluation of supplier performance", "title" => "", "description" => "2.2.21 Evaluation of supplier performance", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_docReview = Question::create(array("section_id" => $sec_sec2->id, "name" => "Document Review", "title" => "", "description" => "2.2.22 Document Review", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_revActPlanDoc = Question::create(array("section_id" => $sec_sec2->id, "name" => "Documentation of review and action planning", "title" => "", "description" => "2.2.23 Documentation of review and action planning with staff for resolution and follow-up review", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualQMSrev = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual Review of Quality Management Systems", "title" => "2.3 Annual Review of Quality Management Systems", "description" => "Does the laboratory management annually perform a review of all quality systems at a management review meeting?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_annualPrevActItems = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual follow-up of action items from previous management reviews", "title" => "", "description" => "2.3.1 Follow-up of action items from previous management reviews", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualCorrActStatus = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual status of corrective actions taken", "title" => "", "description" => "2.3.2 Status of corrective actions taken and required preventive actions", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualRepFromPersonnel = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual reports from managerial and supervisory personnel", "title" => "", "description" => "2.3.3  Reports from managerial and supervisory personnel", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualWorkVolChange = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual changes in volume and type of work", "title" => "", "description" => "2.3.4 Changes in volume and type of work the laboratory undertakes", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualBioRefRangeChange = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual changes in the suitability of biological reference ranges", "title" => "", "description" => "2.3.5 Changes in the suitability of biological reference ranges", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualCliHandbook = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual changes in the client handbook", "title" => "", "description" => "2.3.6 Changes in the client handbook", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualEnvMonLog = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual environmental monitoring log sheets", "title" => "", "description" => "2.3.7 Environmental monitoring log sheets", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualSpeRejLog = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual specimen rejection logbook", "title" => "", "description" => "2.3.8 Specimen rejection logbook", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualEquiCalibManRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual equipment calibration and maintenance records", "title" => "", "description" => "2.3.9 Equipment calibration and maintenance records", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualIqcRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual IQC records across all test areas", "title" => "", "description" => "2.3.10 IQC records across all test areas", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualPtIntLabCo = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual PTs and other forms of Inter-laboratory comparisons", "title" => "", "description" => "2.3.11 Outcomes of PTs and other forms of Inter-laboratory comparisons", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualTatMon = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual Turnaround time", "title" => "", "description" => "2.3.12 Turnaround time", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualQInd = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual Quality indicators", "title" => "", "description" => "2.3.13 Quality indicators", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualRecentIntAudRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual outcomes from recent internal audit records", "title" => "", "description" => "2.3.14 Outcomes from recent internal audit records", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualExtAudRec = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual results of audit(s) or audits by external bodies", "title" => "", "description" => "2.3.15 Results of audit(s) or audits by external bodies", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualCustCompFeed = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual customer complaints and feedback", "title" => "", "description" => "2.3.16 Customer complaints and feedback", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualOccIncLogs = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual occurrence/incidence logs", "title" => "", "description" => "2.3.17 Occurrence/incidence logs, nonconformities and corrective action reports", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualImpProRes = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual results of improvement projects", "title" => "", "description" => "2.3.18 Results of improvement projects", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualOperPro = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual operational procedures", "title" => "", "description" => "2.3.19 Operational procedures (for potential sources of non-conformance and opportunities for improvement)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualRefLabPerfEval = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual evaluation of performance of referral laboratories", "title" => "", "description" => "2.3.20 Evaluation of performance of referral laboratories", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualSuppPerfEval = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual evaluation of supplier performance", "title" => "", "description" => "2.3.21 Evaluation of supplier performance", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualDocReview = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual document Review", "title" => "", "description" => "2.3.22 Document Review", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_annualRevActPlanDoc = Question::create(array("section_id" => $sec_sec2->id, "name" => "Annual documentation of review and action planning", "title" => "", "description" => "2.3.23 Documentation of review and action planning with staff for resolution and follow-up review", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_QMSImpMe = Question::create(array("section_id" => $sec_sec2->id, "name" => "Quality Management System Improvement Measures", "title" => "2.4 Quality Management System Improvement Measures", "description" => "Does the laboratory identify and undertake quality improvement projects?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_commSysLabOper = Question::create(array("section_id" => $sec_sec2->id, "name" => "Communications System on Laboratory Operations", "title" => "2.5 Communications System on Laboratory Operations", "description" => "Does the laboratory communicate with upper management regularly regarding personnel, facility, and operational needs?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 3 - Organization & Personnel
        $question_workSchCo = Question::create(array("section_id" => $sec_sec3->id, "name" => "Workload, Schedule and Coverage", "title" => "3.1 Workload, Schedule and Coverage", "description" => "Do work schedules show task assignments & coordination of work for adequate lab staff coverage?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_duRoDaRo = Question::create(array("section_id" => $sec_sec3->id, "name" => "Duty Roster And Daily Routine", "title" => "3.2 Duty Roster And Daily Routine", "description" => "Are daily routine work tasks established, assigned (duty roster and workstation assignments/tasks), monitored and supervised by qualified professional staff, and which indicates that only authorized personnel perform specific tasks?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_orgChart = Question::create(array("section_id" => $sec_sec3->id, "name" => "Organizational Chart and External/Internal Reporting Systems", "title" => "3.3 Organizational Chart and External/Internal Reporting Systems", "description" => "Are lines of authority and responsibility clearly defined for all lab staff, including the designation of a supervisor and deputies for all key functions?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_qmsOversight = Question::create(array("section_id" => $sec_sec3->id, "name" => "Quality Management System Oversight", "title" => "3.4 Quality Management System Oversight", "description" => "Is there a quality officer/manager with delegated responsibility to oversee compliance with the quality management system?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_perFilSys = Question::create(array("section_id" => $sec_sec3->id, "name" => "Personnel Filing System", "title" => "3.5 Personnel Filing System", "description" => "Are Personnel Files present?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_empOri = Question::create(array("section_id" => $sec_sec3->id, "name" => "Employee Orientation", "title" => "", "description" => "3.5.1 Employee Orientation", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_educTra = Question::create(array("section_id" => $sec_sec3->id, "name" => "Education & Training", "title" => "", "description" => "3.5.2 Education & Training (e.g., degrees/certificates)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_prevExp = Question::create(array("section_id" => $sec_sec3->id, "name" => "Previous experience and work history (e.g. CV)", "title" => "", "description" => "3.5.3 Previous experience and work history (e.g. CV)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_writtenJobDesc = Question::create(array("section_id" => $sec_sec3->id, "name" => "Written job description", "title" => "", "description" => "3.5.4 Written job description with documentation that staff member received and signed a copy of their job description", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_letterOfEmp = Question::create(array("section_id" => $sec_sec3->id, "name" => "Letter of employment or appointment", "title" => "", "description" => "3.5.5 Letter of employment or appointment", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_revOfJobSops = Question::create(array("section_id" => $sec_sec3->id, "name" => "Review of job-relevant SOPs", "title" => "", "description" => "3.5.6 Review of job-relevant SOPs", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_docRevSafetyMan = Question::create(array("section_id" => $sec_sec3->id, "name" => "Documented review of safety manual", "title" => "", "description" => "3.5.7 Documented review of safety manual, evidence of safety training", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_revOfProForEmp = Question::create(array("section_id" => $sec_sec3->id, "name" => "Review of procedure for employees", "title" => "", "description" => "3.5.8 Review of procedure for employees to communicate concerns about test quality and laboratory safety", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_regWithProf = Question::create(array("section_id" => $sec_sec3->id, "name" => "Registration with professional board", "title" => "", "description" => "3.5.9 Registration with professional board", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_traRecDoc = Question::create(array("section_id" => $sec_sec3->id, "name" => "Training record documenting", "title" => "", "description" => "3.5.10 Training record documenting trainings received, vendor training received on-site", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_periodicPerfRev = Question::create(array("section_id" => $sec_sec3->id, "name" => "Periodic Performance Review", "title" => "", "description" => "3.5.11 Periodic Performance Review – including Observation, Competency audit, Coaching / Feedback, on-the-job training", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_docEmpRecog = Question::create(array("section_id" => $sec_sec3->id, "name" => "Documentation of employee recognition", "title" => "", "description" => "3.5.12 Documentation of employee recognition (i.e., employee of the month, letter of commendation, etc.)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hrData = Question::create(array("section_id" => $sec_sec3->id, "name" => "Human Resource (HR) Data", "title" => "", "description" => "3.5.13 Human Resource (HR) Data – (vaccination status, accidental exposure during work injuries, accident history, leave days taken, etc.)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_staffCompAudit = Question::create(array("section_id" => $sec_sec3->id, "name" => "Staff Competency audit and Training", "title" => "3.6 Staff Competency audit and Training", "description" => "Is there a system for competency audit of personnel (both new hires and existing staff) and does it include planning and documentation of retraining and reaudit, when indicated?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_labStaffTra = Question::create(array("section_id" => $sec_sec3->id, "name" => "Laboratory Staff Training", "title" => "3.7 Laboratory Staff Training", "description" => "Does the laboratory have adequate training policies, procedures, and/or training plans, including cross-training within the laboratory team, one-on-one mentoring, and/or off-site external training?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_staffMeet = Question::create(array("section_id" => $sec_sec3->id, "name" => "Staff Meetings", "title" => "3.8 Staff Meetings", "description" => "Are staff meetings held regularly?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "4", "one_star" => "", "user_id" => "1"));
        $question_prevStaffMeet = Question::create(array("section_id" => $sec_sec3->id, "name" => "Follow-up of action items from previous staff meetings", "title" => "", "description" => "3.8.1 Follow-up of action items from previous staff meetings", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_probCompDis = Question::create(array("section_id" => $sec_sec3->id, "name" => "Discussion about problems and complaints", "title" => "", "description" => "3.8.2 Discussion about problems and complaints", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_revOfDoc = Question::create(array("section_id" => $sec_sec3->id, "name" => "Review of documentation", "title" => "", "description" => "3.8.3 Review of documentation", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_commOnRevSops = Question::create(array("section_id" => $sec_sec3->id, "name" => "Communication on reviewed SOPs", "title" => "", "description" => "3.8.4 Communication on reviewed/revised/redundant SOPs", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_systematicPro = Question::create(array("section_id" => $sec_sec3->id, "name" => "Systemic and or recurrent problems", "title" => "", "description" => "3.8.5 Systemic and or recurrent problems and issues addressed, including actions to prevent recurrence", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_priorCorrAct = Question::create(array("section_id" => $sec_sec3->id, "name" => "Prior corrective actions review", "title" => "", "description" => "3.8.6 Review of results from prior corrective actions", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_discEvalOfImp = Question::create(array("section_id" => $sec_sec3->id, "name" => "Discussion and evaluation of improvement topics", "title" => "", "description" => "3.8.7 Discussion and evaluation of improvement topics/projects", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_staffFeed = Question::create(array("section_id" => $sec_sec3->id, "name" => "Feedback given by staff", "title" => "", "description" => "3.8.8 Feedback given by staff that have attended meetings, training, conferences etc.", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_exempPerf = Question::create(array("section_id" => $sec_sec3->id, "name" => "Recognition of employees for exemplary performance", "title" => "", "description" => "3.8.9 Recognition of employees for exemplary performance (i.e., employee of the month, letter of commendation, etc.)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_relayOfReports = Question::create(array("section_id" => $sec_sec3->id, "name" => "Relay of reports and updates", "title" => "", "description" => "3.8.10 Relay of reports and updates from lab attendance at meetings with clinicians (the use of lab services and/or attendance at clinical rounds)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_recordMon = Question::create(array("section_id" => $sec_sec3->id, "name" => "Recording and monitoring of meeting notes", "title" => "", "description" => "3.8.11 Recording and monitoring of meeting notes for progress on issues", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        //  Section 4 - Client Management and Customer Service
        $question_advTraQS = Question::create(array("section_id" => $sec_sec4->id, "name" => "Advice and Training by Qualified Staff", "title" => "4.1 Advice and Training by Qualified Staff", "description" => "Do staff members with appropriate professional qualifications provide clients with advice and/or training regarding required types of samples, choice of examinations, repeat frequency, and interpretation of results?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_labHandbook = Question::create(array("section_id" => $sec_sec4->id, "name" => "Laboratory Handbook for Clients", "title" => "4.2 Laboratory Handbook for Clients", "description" => "Is there a laboratory handbook for laboratory users that includes information on services offered, quality assurance, laboratory operations, sample collection, transport and agreed turnaround times?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_commPoOnDelays = Question::create(array("section_id" => $sec_sec4->id, "name" => "Communication Policy on Delays in Service", "title" => "4.3 Communication Policy on Delays in Service", "description" => "Is timely, documented notification provided to customers when the laboratory experiences delays or interruptions in testing (due to equipment failure, stock outs, staff levels, etc.) or finds it necessary to change examination procedures?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_evalTool = Question::create(array("section_id" => $sec_sec4->id, "name" => "Evaluation Tool and Follow up", "title" => "4.4 Evaluation Tool and Follow up", "description" => "Is there a tool for regularly evaluating client satisfaction and is the feedback received effectively utilized to improve services?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 5 - Equipment
        $question_properEquiPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Adherence to Proper Equipment Protocol", "title" => "5.1 Adherence to Proper Equipment Protocol", "description" => "Is equipment installed and placed as specified in the operator’s manuals and uniquely labeled or marked?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_equipMethVal = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment and Method Validation", "title" => "5.2 Equipment and Method Validation/Verification and Documentation", "description" => "Are newly introduced equipment and methods validated/verified on-site and are records documenting validation available?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipRecMan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Record Maintenance", "title" => "5.3 Equipment Record Maintenance", "description" => "Is current equipment inventory data available on all equipment in the laboratory?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipName = Question::create(array("section_id" => $sec_sec5->id, "name" => "Name of equipment", "title" => "", "description" => "5.3.1 Name of equipment", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_manfCont = Question::create(array("section_id" => $sec_sec5->id, "name" => "Manufacturer's contact details", "title" => "", "description" => "5.3.2 Manufacturer’s contact details", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_condReceived = Question::create(array("section_id" => $sec_sec5->id, "name" => "Condition received (new, used, reconditioned)", "title" => "", "description" => "5.3.3 Condition received (new, used, reconditioned)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_serialNo = Question::create(array("section_id" => $sec_sec5->id, "name" => "Serial number", "title" => "", "description" => "5.3.4 Serial number", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_dateOfPur = Question::create(array("section_id" => $sec_sec5->id, "name" => "Date of purchase", "title" => "", "description" => "5.3.5 Date of purchase", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_outOfSer = Question::create(array("section_id" => $sec_sec5->id, "name" => "Date out of service", "title" => "", "description" => "5.3.6 Date when put 'out of service'", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_dateSerEntry = Question::create(array("section_id" => $sec_sec5->id, "name" => "Date of entry into service", "title" => "", "description" => "5.3.7 Date of entry into service", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_equipManRec = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Maintenance Records", "title" => "5.4 Equipment Maintenance Records", "description" => "Is relevant equipment service information readily available in the laboratory?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_serviceContInf = Question::create(array("section_id" => $sec_sec5->id, "name" => "Service contract information", "title" => "", "description" => "5.4.1 Service contract information", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_serviceProCont = Question::create(array("section_id" => $sec_sec5->id, "name" => "Contact details for service provider", "title" => "", "description" => "5.4.2 Contact details for service provider", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_decontaRec = Question::create(array("section_id" => $sec_sec5->id, "name" => "Decontamination Records", "title" => "", "description" => "5.4.3 Decontamination Records", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_perfManRec = Question::create(array("section_id" => $sec_sec5->id, "name" => "Performance and maintenance records", "title" => "", "description" => "5.4.4 Performance and maintenance records", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_lastSerDate = Question::create(array("section_id" => $sec_sec5->id, "name" => "Last date of service", "title" => "", "description" => "5.4.5 Last date of service", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_nextSerDate = Question::create(array("section_id" => $sec_sec5->id, "name" => "Next date of service", "title" => "", "description" => "5.4.6 Next date of service", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_currLoc = Question::create(array("section_id" => $sec_sec5->id, "name" => "Current location", "title" => "", "description" => "5.4.7 Current location", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_obsoEquipPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Obsolete Equipment Procedures", "title" => "5.5 Obsolete Equipment Procedures", "description" => "Is non-functioning equipment appropriately labeled and removed from the laboratory & storage areas?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipCalibPro = Question::create(array("section_id" => $sec_sec5->id, "name" => "Adherence to Equipment Calibration Protocol", "title" => "5.6 Adherence to Equipment Calibration Protocol", "description" => "Is routine calibration of laboratory equipment (including pipettes, centrifuges, balances, and thermometers) scheduled, as indicated on the equipment, and verified?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipPrevMan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Preventive Maintenance", "title" => "5.7 Equipment Preventive Maintenance", "description" => "Is routine preventive maintenance performed on all equipment and recorded according to SOPs/log sheet?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipSerMan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Service Maintenance", "title" => "5.8 Equipment Service Maintenance", "description" => "Is equipment routinely serviced according to schedule by qualified and competent personnel and is this information documented in appropriate logs?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipPartsRe = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Parts for Repair", "title" => "5.9 Equipment Parts for Repair", "description" => "Are parts available to perform minor repairs as per manufacturer’s instructions?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipMalf = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Malfunction", "title" => "5.10 Equipment Malfunction - Response and Documentation", "description" => "Is equipment malfunction resolved by the effectiveness of the corrective action program and the associated root cause analysis?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipRepMon = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Repair Monitoring and Documentation", "title" => "5.11 Equipment Repair Monitoring and Documentation", "description" => "Are repair orders monitored to determine if the service is completed? Does the laboratory verify and document that it is in proper working order before being put it back into service?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipFailPlan = Question::create(array("section_id" => $sec_sec5->id, "name" => "Equipment Failure - Contingency Plan", "title" => "5.12 Equipment Failure - Contingency Plan", "description" => "Are there back-up procedures for equipment failure (including SOPs for handling specimens during these times, identification of a back-up lab for testing, and referral procedures)?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_manManual = Question::create(array("section_id" => $sec_sec5->id, "name" => "Manufacturer's Operator Manual", "title" => "5.13 Manufacturer's Operator Manual", "description" => "Are the equipment manufacturer’s operator manuals readily available to testing staff, and where possible, available in the language understood by staff?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_effOfQMS = Question::create(array("section_id" => $sec_sec5->id, "name" => "Communication on Effectiveness of QMS", "title" => "5.14 Communication on Effectiveness of Quality Management System", "description" => "Are equipment specifications and maintenance needs routinely communicated to upper management?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_labTestSer = Question::create(array("section_id" => $sec_sec5->id, "name" => "Laboratory Testing Services", "title" => "5.15 Laboratory Testing Services", "description" => "Has the laboratory provided uninterrupted testing services, with no disruptions due to equipment failure in the last year (or since the last audit)?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 6 - Internal Audit
        $question_internalAudits = Question::create(array("section_id" => $sec_sec6->id, "name" => "Internal Audits", "title" => "6.1 Internal Audits", "description" => "Are internal audits conducted at intervals as defined in the quality manual and do these audits address areas important to patient care?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "5", "one_star" => "", "user_id" => "1"));
        $question_inAuditCarriers = Question::create(array("section_id" => $sec_sec6->id, "name" => "Internal Audit Carriers", "title" => "", "description" => "6.1.1 Are audits being carried out by persons who are not involved in lab activities in the section being audited?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_inAuditConductor = Question::create(array("section_id" => $sec_sec6->id, "name" => "Internal Audit Carriers conductors", "title" => "", "description" => "6.1.2 Are the personnel conducting the internal audits trained and competent in auditing?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_causeAnalysis = Question::create(array("section_id" => $sec_sec6->id, "name" => "Cause Analysis", "title" => "", "description" => "6.1.3 Is cause analysis performed for nonconformities/noted deficiencies?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_inAuditFindings = Question::create(array("section_id" => $sec_sec6->id, "name" => "Internal audit findings", "title" => "", "description" => "6.1.4 Are internal audit findings documented and presented to the laboratory management and relevant staff for review?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_auditRecomm = Question::create(array("section_id" => $sec_sec6->id, "name" => "Audit Recommendations and Action Plan & Follow up", "title" => "6.2 Audit Recommendations and Action Plan & Follow up", "description" => "Are recommendations for corrective/preventive actions made based on audit findings; is an action plan developed with clear timelines and documented follow-up?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "5", "one_star" => "", "user_id" => "1"));
        //  Section 7 - Purchasing and Inventory
        $question_invBudget = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory and Budgeting System", "title" => "7.1 Inventory and Budgeting System", "description" => "Is there a system for accurately forecasting needs for supplies and reagents?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_serSuppPerfRev = Question::create(array("section_id" => $sec_sec7->id, "name" => "Service Supplier Performance Review", "title" => "7.2 Service Supplier Performance Review", "description" => "Are supply & reagent specifications periodically reviewed and are approved suppliers identified?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_manSuppList = Question::create(array("section_id" => $sec_sec7->id, "name" => "Manufacturer/Supplier List", "title" => "7.3 Manufacturer/Supplier List", "description" => "Is an up-to-date list of approved manufacturers/suppliers available and includes their complete contact information?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_budgetaryPro = Question::create(array("section_id" => $sec_sec7->id, "name" => "Budgetary Projections", "title" => "7.4 Budgetary Projections", "description" => "Are budgetary projections based on personnel, test, facility and equipment needs, and quality assurance procedures and materials?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_manRevSuppReq = Question::create(array("section_id" => $sec_sec7->id, "name" => "Management Review of Supply Requests", "title" => "7.5 Management Review of Supply Requests", "description" => "Does management review the finalized supply requests?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_orderTrack = Question::create(array("section_id" => $sec_sec7->id, "name" => "Order Tracking, Inspection, and Documentation", "title" => "7.6 Order Tracking, Inspection, and Documentation", "description" => "Are all orders tracked until delivery and inspected, receipted, and labeled with date of receipt when the orders are checked in?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_invConSys = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory Control System", "title" => "7.7 Inventory Control System", "description" => "Is an inventory control system in place?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_consumeAccRej = Question::create(array("section_id" => $sec_sec7->id, "name" => "Acceptance and rejection of consumables", "title" => "", "description" => "7.7.1 Acceptance and rejection of consumables", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_lotNumberRec = Question::create(array("section_id" => $sec_sec7->id, "name" => "Recording of lot number", "title" => "", "description" => "7.7.2 Recording of lot number, date of receipt, received by and date placed into service", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_consumeStorage = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage of consumables", "title" => "", "description" => "7.7.3 Storage of consumables", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_labInvSys = Question::create(array("section_id" => $sec_sec7->id, "name" => "Laboratory Inventory System", "title" => "7.8 Laboratory Inventory System", "description" => "Are inventory records complete and accurate, with minimum and maximum stock levels denoted?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_usageRateTrack = Question::create(array("section_id" => $sec_sec7->id, "name" => "Usage Rate Tracking of Consumables", "title" => "7.9 Usage Rate Tracking of Consumables", "description" => "Is the consumption rate monitored?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_invStockCount = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory Control System – Stock Counts", "title" => "7.10 Inventory Control System – Stock Counts", "description" => "Are stock counts routinely performed?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_storageArea = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage Area", "title" => "7.11 Storage Area", "description" => "Are storage areas set up and monitored appropriately?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_storageWellOrg = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage area well-organized", "title" => "", "description" => "7.11.1 Is the storage area well-organized and free of clutter?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_desigPlaces = Question::create(array("section_id" => $sec_sec7->id, "name" => "Designated places", "title" => "", "description" => "7.11.2 Are there designated places labeled for all inventory items?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hazardousChem = Question::create(array("section_id" => $sec_sec7->id, "name" => "Hazardous chemicals stored appropriately", "title" => "", "description" => "7.11.3 Are hazardous chemicals stored appropriately?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_coldStorage = Question::create(array("section_id" => $sec_sec7->id, "name" => "Adequate cold storage", "title" => "", "description" => "7.11.4 Is adequate cold storage available?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_storageAreaMon = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage areas monitored", "title" => "", "description" => "7.11.5 Are storage areas monitored as per prescribed storage conditions?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ambientTemp = Question::create(array("section_id" => $sec_sec7->id, "name" => "Ambient temperature", "title" => "", "description" => "7.11.6 Is the ambient temperature monitored routinely?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_directSunlight = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage in direct sunlight", "title" => "", "description" => "7.11.7 Is storage in direct sunlight avoided?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_adequateVent = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage area adequately ventilated", "title" => "", "description" => "7.11.8 Is the storage area adequately ventilated?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_cleanDustPests = Question::create(array("section_id" => $sec_sec7->id, "name" => "Clean and free of dust and pests", "title" => "", "description" => "7.11.9 Is the storage area clean and free of dust and pests?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_accessControl = Question::create(array("section_id" => $sec_sec7->id, "name" => "Storage areas access-controlled", "title" => "", "description" => "7.11.10 Are storage areas access-controlled?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_wastageMin = Question::create(array("section_id" => $sec_sec7->id, "name" => "Inventory Organization and Wastage Minimization", "title" => "7.12 Inventory Organization and Wastage Minimization", "description" => "Is First-Expiration-First-Out (FEFO) practiced?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_dispExProd = Question::create(array("section_id" => $sec_sec7->id, "name" => "Disposal of Expired Products", "title" => "7.13 Disposal of Expired Products", "description" => "Are expired products labeled and disposed properly?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_prodExpiration = Question::create(array("section_id" => $sec_sec7->id, "name" => "Product Expiration", "title" => "7.14 Product Expiration", "description" => "Are all reagents/test kits in use (and in stock) currently within the manufacturer-assigned expiration dates or within stability?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_labTestServices = Question::create(array("section_id" => $sec_sec7->id, "name" => "Laboratory Testing Services", "title" => "7.15 Laboratory Testing Services", "description" => "Has the laboratory provided uninterrupted testing services, with no disruptions due to stock outs in the last year or since last assessment?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 8 - Process Control and Internal & External Quality Assurance
        $question_patIdGuide = Question::create(array("section_id" => $sec_sec8->id, "name" => "Patient Identification guidelines", "title" => "", "description" => "Are guidelines for patient identification, specimen collection (including client safety), labeling, and transport readily available to persons responsible for primary sample collection?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_sampRecPro = Question::create(array("section_id" => $sec_sec8->id, "name" => "Adequate sample receiving procedures", "title" => "", "description" => "8.2 Are adequate sample receiving procedures in place?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "Some Elements Required", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_specLabel = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimens Labelled", "title" => "", "description" => "8.2.1 Are specimens labeled with patient ID, test, and date, time of collection, date of collection and authorized requester?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_reqForm = Question::create(array("section_id" => $sec_sec8->id, "name" => "Requisition form", "title" => "", "description" => "8.2.2 Are all test requests accompanied by an acceptable and approved test requisition form?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_afterHours = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimen received after hours", "title" => "", "description" => "8.2.3 If not a 24 hour lab, is there a documented method for handling of specimens received after hours?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_transSheet = Question::create(array("section_id" => $sec_sec8->id, "name" => "Sample delivery or transmittal sheet", "title" => "", "description" => "8.2.4 Are all samples that are either received or referred to a higher level laboratory accompanied by a sample delivery checklist or transmittal sheet?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_accRejCrit = Question::create(array("section_id" => $sec_sec8->id, "name" => "Acceptance/rejection criteria", "title" => "", "description" => "8.2.5 Are received specimens evaluated according to acceptance/rejection criteria?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_specLogged = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimen logged", "title" => "", "description" => "8.2.6 Are specimens logged appropriately upon receipt in the laboratory (including date, time, and name of receiving officer)?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_portions = Question::create(array("section_id" => $sec_sec8->id, "name" => "Portions tracked", "title" => "", "description" => "8.2.7 When samples are split, can the portions be traced back to the primary sample?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_2IdSys = Question::create(array("section_id" => $sec_sec8->id, "name" => "Two-identifier system", "title" => "", "description" => "8.2.8 Is a two-identifier system in use and is each sample assigned a unique identifying number?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_urgentSpec = Question::create(array("section_id" => $sec_sec8->id, "name" => "Urgent Specimen", "title" => "", "description" => "8.2.9 Are procedures in place to process 'urgent' specimens and verbal requests?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_corrWorksta = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimens delivered to the correct workstations", "title" => "", "description" => "8.2.10 Are specimens delivered to the correct workstations in a timely manner?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_specStoredApp = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimens stored appropriately", "title" => "", "description" => "8.3 Are specimens stored appropriately prior to testing?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_specDispSafe = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimens disposed of in a safe manner", "title" => "", "description" => "8.3.1 Are specimens disposed of in a safe manner?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_specPackage = Question::create(array("section_id" => $sec_sec8->id, "name" => "Specimens packaged appropriately", "title" => "", "description" => "8.4 Are specimens packaged appropriately according to local and or international regulations and transported to referral laboratories within acceptable timeframes?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_referredSpecLog = Question::create(array("section_id" => $sec_sec8->id, "name" => "Referred specimens tracked properly", "title" => "", "description" => "8.5 Are referred specimens tracked properly using a logbook or tracking form?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_procManual = Question::create(array("section_id" => $sec_sec8->id, "name" => "Complete procedure manual", "title" => "", "description" => "8.6 Is complete procedure manual available at the workstation or in the work area?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "1", "user_id" => "1"));
        $question_reagentLogbook = Question::create(array("section_id" => $sec_sec8->id, "name" => "Reagent logbook for lot number and dates", "title" => "", "description" => "8.7 Is there a reagent logbook for lot number and dates of opening that reflects verification of new lots?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_consumeVer = Question::create(array("section_id" => $sec_sec8->id, "name" => "Consumables verified before use", "title" => "", "description" => "8.8 Is each new lot number, new shipment of reagents, or consumables verified before use?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_inQualCo = Question::create(array("section_id" => $sec_sec8->id, "name" => "Internal quality control performed", "title" => "", "description" => "8.9  Is internal quality control performed, documented, and verified before releasing patient results?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "1", "user_id" => "1"));
        $question_qcResMon = Question::create(array("section_id" => $sec_sec8->id, "name" => "QC results monitored and reviewed", "title" => "", "description" => "8.10 Are QC results monitored and reviewed (biases, shifts, trends, and Levy-Jennings charts)? Is there documentation of corrective action when quality control results exceed the acceptable range in a timely manner?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_envConditons = Question::create(array("section_id" => $sec_sec8->id, "name" => "", "title" => "", "description" => "8.11 Are environmental conditions are checked and reviewed accurately?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_roomTemp = Question::create(array("section_id" => $sec_sec8->id, "name" => "Room temperature", "title" => "", "description" => "8.11.1 Room temperature", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_freezers = Question::create(array("section_id" => $sec_sec8->id, "name" => "Freezers", "title" => "", "description" => "8.11.2 Freezers", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_refrigerator = Question::create(array("section_id" => $sec_sec8->id, "name" => "Refrigerator", "title" => "", "description" => "8.11.3 Refrigerator", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_incubators = Question::create(array("section_id" => $sec_sec8->id, "name" => "Incubators", "title" => "", "description" => "8.11.4 Incubators", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_waterBath = Question::create(array("section_id" => $sec_sec8->id, "name" => "Water Bath", "title" => "", "description" => "8.11.5 Water Bath", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_accRanges = Question::create(array("section_id" => $sec_sec8->id, "name" => "Acceptable ranges defined", "title" => "", "description" => "8.12 Have acceptable ranges been defined for all temperature- dependent equipment with procedures and documentation of action taken in response to out of range temperatures?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_externalPT = Question::create(array("section_id" => $sec_sec8->id, "name" => "External Proficiency Tests", "title" => "", "description" => "8.13 Does the laboratory participate in external Proficiency Testing (PT) or exercise an alternative performance audit system when appropriate?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "1", "user_id" => "1"));
        $question_sampDist = Question::create(array("section_id" => $sec_sec8->id, "name" => "Samples routinely distributed", "title" => "", "description" => "8.13.1 Are blinded characterized samples routinely distributed for testing to determine accuracy?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ptProvAccreditted = Question::create(array("section_id" => $sec_sec8->id, "name" => "PT samples come from providers who are accredited", "title" => "", "description" => "8.13.2 Do PT samples come from providers who are accredited or approved?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ptSpecHandledNormally = Question::create(array("section_id" => $sec_sec8->id, "name" => "PT specimens handled normally", "title" => "", "description" => "8.13.3 Are PT specimens handled and tested the same way as patient specimens?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ptResCauseAnalysis = Question::create(array("section_id" => $sec_sec8->id, "name" => "Cause analysis performed for unacceptable PT results", "title" => "", "description" => "8.13.4 Is cause analysis performed for unacceptable PT results?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ptResCorrAct = Question::create(array("section_id" => $sec_sec8->id, "name" => "Corrective action for unacceptable PT results", "title" => "", "description" => "8.13.5 Is corrective action documented for unacceptable PT results?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_testReqResCheck = Question::create(array("section_id" => $sec_sec8->id, "name" => "Test requests checked with test results", "title" => "", "description" => "8.14 Are test requests checked with test results, thereby assuring the accuracy and completion of all tests?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 9 - Information Management
        $question_testResRepSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test Result Reporting System", "title" => "9.1 Test Result Reporting System", "description" => "Are test results legible, technically verified by an authorized person, and confirmed against patient identity?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_testPersonnel = Question::create(array("section_id" => $sec_sec9->id, "name" => "Testing Personnel", "title" => "9.2 Testing Personnel", "description" => "Are testing personnel identified on the requisition and record?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_testResRec = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test Result Records", "title" => "9.3 Test Result Records", "description" => "Are test results recorded in a logbook or electronic record in a timely manner?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_analyticSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Analytic System/Method Tracing", "title" => "9.4 Analytic System/Method Tracing", "description" => "When more than one instrument is in use for the same test, are test results traceable to the equipment used for testing?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_resXCheckSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Result Cross-check System", "title" => "9.5 Result Cross-check System", "description" => "Is there a system for reviewing for transcription errors?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_arcDataLabel = Question::create(array("section_id" => $sec_sec9->id, "name" => "Archived Data Labeling and Storage", "title" => "9.6 Archived Data Labeling and Storage", "description" => "Are archived results (paper or data-storage media) properly labeled and stored in a secure location accessible only to authorized personnel?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_backupSys = Question::create(array("section_id" => $sec_sec9->id, "name" => "Information and Data Backup System", "title" => "9.7 Information and Data Backup System", "description" => "Are there documented procedures to prevent the loss of test result data in the event of hardware/software failure, fire or theft?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_testResReport = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test Result Report", "title" => "9.8 Test Result Report", "description" => "Is the laboratory result report(s) in a standard form determined to be acceptable by its customers?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_reportId = Question::create(array("section_id" => $sec_sec9->id, "name" => "Laboratory issuing the report clearly identified", "title" => "", "description" => "9.8.1 Is the laboratory issuing the report clearly identified?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_patDemography = Question::create(array("section_id" => $sec_sec9->id, "name" => "Report contains the patient demography", "title" => "", "description" => "9.8.2 Does the report contain the patient's name, address, and the hospital/destination of the report?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_testRequester = Question::create(array("section_id" => $sec_sec9->id, "name" => "Person requesting the test indicated", "title" => "", "description" => "9.8.3 Is the name of the person requesting the test indicated on the report?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_specTestInc = Question::create(array("section_id" => $sec_sec9->id, "name" => "Sample received and the test requested included", "title" => "", "description" => "9.8.4 Is the type of sample received and the test requested included in the report?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_specCollDate = Question::create(array("section_id" => $sec_sec9->id, "name" => "Date and time for specimen collection", "title" => "", "description" => "9.8.5 Are the date and time for specimen collection, receipt of specimen, and release of report indicated?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_bioRefRange = Question::create(array("section_id" => $sec_sec9->id, "name" => "Report indicates biological reference ranges", "title" => "", "description" => "9.8.6 Does the report indicate biological reference ranges for each test?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_siUnits = Question::create(array("section_id" => $sec_sec9->id, "name" => "SI units", "title" => "", "description" => "9.8.7 Is the result reported in SI units where applicable?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_resInterp = Question::create(array("section_id" => $sec_sec9->id, "name" => "Space for interpretation of results", "title" => "", "description" => "9.8.8 Is there space for interpretation of results, when applicable, and for indication of when specimens are received and unsuitable for the procedure requested for testing?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_authority = Question::create(array("section_id" => $sec_sec9->id, "name" => "Result contain the name of the person authorizing release", "title" => "", "description" => "9.8.9 Does the result contain the name of the person authorizing release of the report and the signature of the person accepting responsibility for its content?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_testResult = Question::create(array("section_id" => $sec_sec9->id, "name" => "Test Result", "title" => "9.9 Test Result", "description" => "Are test results validated, interpreted and released by appropriately-authorized personnel?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 10 - Corerective Action
        $question_rootCause = Question::create(array("section_id" => $sec_sec10->id, "name" => "Root Cause", "title" => "", "description" => "10.1 Are all laboratory-documented occurrence reports indicating the root cause of the problem(s) and corrective & preventive actions taken to prevent recurrence? (There must be at least a description of what happened and what was done to prevent it from happening again.)", "question_type" => "0", "required" => "1", "info" => "There must be at least a description of what happened and what was done to prevent it from happening again", "comment" => "", "score" => "5", "one_star" => "", "user_id" => "1"));
        $question_nonConfWork = Question::create(array("section_id" => $sec_sec10->id, "name" => "Non-conforming work reviewed", "title" => "", "description" => "10.2 Is non-conforming work reviewed and submitted for troubleshooting and cause analysis?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_nonConfAspQMS = Question::create(array("section_id" => $sec_sec10->id, "name" => "Non-conforming aspects of the quality management system documented", "title" => "", "description" => "10.3 Is corrective action performed on all non-conforming aspects of the quality management system documented?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_resWithheld = Question::create(array("section_id" => $sec_sec10->id, "name" => "Results withheld", "title" => "", "description" => "10.3.1 Are results withheld, if indicated by the level of control violated? (ISO 4.9.1 part d)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_recCorrect = Question::create(array("section_id" => $sec_sec10->id, "name" => "Recalled and corrected", "title" => "", "description" => "10.3.2 Have these been recalled and corrected, if results have been released? (ISO 4.9.1 part f)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_approvedAuthPer = Question::create(array("section_id" => $sec_sec10->id, "name" => "Approved by an authorized person", "title" => "", "description" => "10.3.3 Is this approved by an authorized person, when testing resumes? (ISO 4.9.1.part g)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_discResTrack = Question::create(array("section_id" => $sec_sec10->id, "name" => "Discordant results tracked", "title" => "", "description" => "10.4 Are discordant results tracked and appropriate corrective action taken?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 11 - Occurence/Incident Management & Process Improvement
        $question_graphTools = Question::create(array("section_id" => $sec_sec11->id, "name" => "Graphical tools (charts and graphs) used", "title" => "", "description" => "11.1 Are graphical tools (charts and graphs) used to communicate quality findings and identify trends?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_qIndTracked = Question::create(array("section_id" => $sec_sec11->id, "name" => "Quality indicators selected, tracked, and reviewed", "title" => "", "description" => "11.2 Are quality indicators (TAT, rejected specimens, stock outs, etc.) selected, tracked, and reviewed regularly to monitor laboratory performance and identify potential quality improvement activities?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "5", "one_star" => "", "user_id" => "1"));
        $question_labPerfImprove = Question::create(array("section_id" => $sec_sec11->id, "name" => "Quality indicators used to improve lab performance", "title" => "", "description" => "11.3 Are the outcomes of internal and external audits, PT, customer feedback and all other information derived from the tracking of quality indicators used to improve lab performance?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_effLabPerfImpro = Question::create(array("section_id" => $sec_sec11->id, "name" => "Effectiveness of improved quality of lab performance", "title" => "", "description" => "11.4 Is the outcome of the action taken checked and monitored to determine the effectiveness of improved quality of lab performance?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Section 12 - Facilities and Safety
        $question_sizeOfLab = Question::create(array("section_id" => $sec_sec12->id, "name" => "Size of the laboratory adequate", "title" => "", "description" => "12.1 Is the size of the laboratory adequate and the layout of the laboratory, as a whole, organized so that workstations are positioned for optimal workflow?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_patCareTest = Question::create(array("section_id" => $sec_sec12->id, "name" => "Patient care and testing", "title" => "", "description" => "12.2 Are the patient care and testing areas of the laboratory distinctly separate from one another?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_workstationMan = Question::create(array("section_id" => $sec_sec12->id, "name" => "Individual workstation maintained", "title" => "", "description" => "12.3 Is each individual workstation maintained free of clutter and set up for efficient operation?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_equipPlacement = Question::create(array("section_id" => $sec_sec12->id, "name" => "Equipment placement", "title" => "", "description" => "12.3.1 Does the equipment placement/layout facilitate optimum workflow?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_neededSupplies = Question::create(array("section_id" => $sec_sec12->id, "name" => "Needed supplies present and easily accessible", "title" => "", "description" => "12.3.2 Are all needed supplies present and easily accessible?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_chairStool = Question::create(array("section_id" => $sec_sec12->id, "name" => "Stools at the workstations", "title" => "", "description" => "12.3.3 Are the chairs/stools at the workstations appropriate for bench height and the testing operations being performed? (ISO 15190: 6.3.5)", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 6.3.5", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_refMaterial = Question::create(array("section_id" => $sec_sec12->id, "name" => "Reference material readily available", "title" => "", "description" => "12.3.4 Is reference material readily available ( critical values and required action, population reference ranges, frequently called numbers?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_phyWorkEnv = Question::create(array("section_id" => $sec_sec12->id, "name" => "Physical work environment appropriate", "title" => "", "description" => "12.4 Is the physical work environment appropriate for testing?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_freeOfClutter = Question::create(array("section_id" => $sec_sec12->id, "name" => "Free of clutter", "title" => "", "description" => "12.4.1 Free of clutter", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 13.0", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_adVent = Question::create(array("section_id" => $sec_sec12->id, "name" => "Adequately ventilated", "title" => "", "description" => "12.4.2 Adequately ventilated?", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 6.3.3", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_excessMo = Question::create(array("section_id" => $sec_sec12->id, "name" => "Free of excess moisture", "title" => "", "description" => "12.4.3 Free of excess moisture?", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 6.3.2", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_lit = Question::create(array("section_id" => $sec_sec12->id, "name" => "Adequately lit", "title" => "", "description" => "12.4.4 Adequately lit?", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 6.3.1", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_climateCon = Question::create(array("section_id" => $sec_sec12->id, "name" => "Climate-controlled", "title" => "", "description" => "12.4.5 Climate-controlled for optimum equipment function?", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 6.3.2", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_filtersChecked = Question::create(array("section_id" => $sec_sec12->id, "name" => "Filters checked", "title" => "", "description" => "12.4.6 Are filters checked, cleaned and/or replaced at regular intervals, where air-conditioning is installed?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_wireCables = Question::create(array("section_id" => $sec_sec12->id, "name" => "Wires and cables properly located", "title" => "", "description" => "12.4.7 Are wires and cables properly located and protected from traffic?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_generator = Question::create(array("section_id" => $sec_sec12->id, "name" => "Functioning back-up power supply", "title" => "", "description" => "12.4.8 Is there a functioning back-up power supply (generator)?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_criticalEquip = Question::create(array("section_id" => $sec_sec12->id, "name" => "Critical equipment supported by uninterrupted power", "title" => "", "description" => "12.4.9 Is critical equipment supported by uninterrupted power source (UPS) systems?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_waterHazards = Question::create(array("section_id" => $sec_sec12->id, "name" => "Equipment placed away from water hazards", "title" => "", "description" => "12.4.10 Is equipment placed appropriately (away from water hazards, out of traffic areas)?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_prolongedPowerDis = Question::create(array("section_id" => $sec_sec12->id, "name" => "Prolonged electricity disruption", "title" => "", "description" => "12.4.11 Is a contingency plan in place for continued testing in the event of prolonged electricity disruption?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_deionizedWater = Question::create(array("section_id" => $sec_sec12->id, "name" => "Deionized water (DI) or distilled water", "title" => "", "description" => "12.4.12 Are appropriate provisions made for adequate water supply, including deionized water (DI) or distilled water, if needed?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_clericalWork = Question::create(array("section_id" => $sec_sec12->id, "name" => "Clerical work completed outside the testing area", "title" => "", "description" => "12.4.13 Is clerical work completed outside the testing area?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_majSafetySignage = Question::create(array("section_id" => $sec_sec12->id, "name" => "Major safety signage posted", "title" => "", "description" => "12.4.14 Is major safety signage posted and enforced including NO EATING, SMOKING, DRINKING?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_secUnauthorized = Question::create(array("section_id" => $sec_sec12->id, "name" => "Secured from unauthorized access", "title" => "", "description" => "12.5 Is the laboratory properly secured from unauthorized access with appropriate signage?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_dedColdRoom = Question::create(array("section_id" => $sec_sec12->id, "name" => "Laboratory-dedicated cold and room temperature", "title" => "", "description" => "12.6 Is laboratory-dedicated cold and room temperature storage free of staff food items, and are patient samples stored separately from reagents and blood products in the laboratory refrigerators and freezers?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_workAreaClean = Question::create(array("section_id" => $sec_sec12->id, "name" => "Work area clean and free of leakage", "title" => "", "description" => "12.7 Is the work area clean and free of leakage & spills, and are disinfection procedures conducted and documented?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_bioSafetyCab = Question::create(array("section_id" => $sec_sec12->id, "name" => "Certified and appropriate Biosafety cabinet", "title" => "", "description" => "12.8 Is a certified and appropriate Biosafety cabinet (or an acceptable alternative processing procedure) in use for all specimens or organisms considered to be highly contagious by airborne routes? (Biosafety cabinet should be recertified according to national protocol).", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_labSafetyManual = Question::create(array("section_id" => $sec_sec12->id, "name" => "Laboratory safety manual available", "title" => "", "description" => "12.9 Is a laboratory safety manual available, accessible, and up-to-date?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "3", "one_star" => "", "user_id" => "1"));
        $question_bloboPre = Question::create(array("section_id" => $sec_sec12->id, "name" => "Blood and Body Fluid Precautions", "title" => "", "description" => "12.9.1 Blood and Body Fluid Precautions", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hazardWasteDisp = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous Waste Disposal", "title" => "", "description" => "12.9.2 Hazardous Waste Disposal", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hazardChem = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous Chemicals", "title" => "", "description" => "12.9.3 Hazardous Chemicals / Materials", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_msds = Question::create(array("section_id" => $sec_sec12->id, "name" => "MSDS Sheets", "title" => "", "description" => "12.9.4 MSDS Sheets", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_persProEquip = Question::create(array("section_id" => $sec_sec12->id, "name" => "Personal protective equipment", "title" => "", "description" => "12.9.5 Personal protective equipment", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_vaccination = Question::create(array("section_id" => $sec_sec12->id, "name" => "Vaccination", "title" => "", "description" => "12.9.6 Vaccination", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_prophylaxis = Question::create(array("section_id" => $sec_sec12->id, "name" => "Post-Exposure Prophylaxis", "title" => "", "description" => "12.9.7 Post-Exposure Prophylaxis", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_fireSafety = Question::create(array("section_id" => $sec_sec12->id, "name" => "Fire Safety", "title" => "", "description" => "12.9.8 Fire Safety", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_elecSafety = Question::create(array("section_id" => $sec_sec12->id, "name" => "Electrical safety", "title" => "", "description" => "12.9.9 Electrical safety", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_suffWasteDisp = Question::create(array("section_id" => $sec_sec12->id, "name" => "Sufficient waste disposal available", "title" => "", "description" => "12.10 Is sufficient waste disposal available and is waste separated into infectious and non-infectious waste, with infectious waste autoclaved, incinerated, or buried?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_hazardMaterials = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous materials properly handled", "title" => "", "description" => "12.11 Are hazardous chemicals / materials properly handled?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_hazardChemLabeled = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly labeled", "title" => "", "description" => "12.11.1 Are hazardous chemicals properly labeled?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hazardChemStored = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly stored", "title" => "", "description" => "12.11.2 Are hazardous chemicals properly stored?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hazardChemUtilized = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly utilized", "title" => "", "description" => "12.11.3 Are hazardous chemicals properly utilized?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hazardChemDisposed = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hazardous chemicals properly disposed", "title" => "", "description" => "12.11.4 Are hazardous chemicals properly disposed?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "1", "user_id" => "1"));
        $question_sharpsHandled = Question::create(array("section_id" => $sec_sec12->id, "name" => "Sharp containers handled", "title" => "", "description" => "12.12 Are 'sharps' handled and disposed of properly in 'sharps' containers that are appropriately utilized?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_overallSafety = Question::create(array("section_id" => $sec_sec12->id, "name" => "Overall safety program", "title" => "", "description" => "12.13 Is fire safety included as part of the laboratory’s overall safety program?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_elecCords = Question::create(array("section_id" => $sec_sec12->id, "name" => "All electricals in good repair", "title" => "", "description" => "12.13.1 Are all electrical cords, plugs, and receptacles used appropriately and in good repair?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_extinguisher = Question::create(array("section_id" => $sec_sec12->id, "name" => "Appropriate fire extinguisher available", "title" => "", "description" => "12.13.2 Is an appropriate fire extinguisher available, properly placed, in working condition, and routinely inspected?", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 19.7", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_fireWarning = Question::create(array("section_id" => $sec_sec12->id, "name" => "Operational fire warning system", "title" => "", "description" => "12.13.3 Is an operational fire warning system in place in laboratory with periodic fire drills?", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 19.3", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_safetyInspec = Question::create(array("section_id" => $sec_sec12->id, "name" => "Safety inspections conducted regularly", "title" => "", "description" => "12.14 Are safety inspections or audits conducted regularly and documented?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_stdSafetyEquip = Question::create(array("section_id" => $sec_sec12->id, "name" => "Standard safety equipment available", "title" => "", "description" => "12.15 Is standard safety equipment available and in use in the laboratory?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_bioSafetyCabinets = Question::create(array("section_id" => $sec_sec12->id, "name" => "Biosafety cabinet", "title" => "", "description" => "12.15.1 Biosafety cabinet(s)", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 16", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_centrifuge = Question::create(array("section_id" => $sec_sec12->id, "name" => "Covers on centrifuge", "title" => "", "description" => "12.15.2 Covers on centrifuge(s)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_handwash = Question::create(array("section_id" => $sec_sec12->id, "name" => "Hand-washing station", "title" => "", "description" => "12.15.3 Hand-washing station", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 12.7", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_eyewash = Question::create(array("section_id" => $sec_sec12->id, "name" => "Eyewash station/bottle", "title" => "", "description" => "12.15.4 Eyewash station/bottle(s) and showers where applicable", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 12.10", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_spillKit = Question::create(array("section_id" => $sec_sec12->id, "name" => "Spill kit", "title" => "", "description" => "12.15.5 Spill kit(s)", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_firstAid = Question::create(array("section_id" => $sec_sec12->id, "name" => "First aid kit", "title" => "", "description" => "12.15.6 First aid kit(s)", "question_type" => "0", "required" => "1", "info" => "ISO 15190: 12.9", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_ppe = Question::create(array("section_id" => $sec_sec12->id, "name" => "Personal protective equipment", "title" => "", "description" => "12.16 Is personal protective equipment (PPE) easily accessible at the workstation and utilized appropriately and consistently?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "1", "user_id" => "1"));
        $question_labPersVacc = Question::create(array("section_id" => $sec_sec12->id, "name" => "Vaccination/preventive measures", "title" => "", "description" => "12.17 Are laboratory personnel offered appropriate vaccination/preventive measures?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_prophyPoSops = Question::create(array("section_id" => $sec_sec12->id, "name" => "Post-exposure prophylaxis policies and procedures", "title" => "", "description" => "12.18 Are post-exposure prophylaxis policies and procedures posted and implemented after possible and known exposures?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_injuriesLog = Question::create(array("section_id" => $sec_sec12->id, "name" => "Occupational injuries Log", "title" => "", "description" => "12.19 Are occupational injuries, medical screening or illnesses documented in the safety occurrence log?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_workerBioTrained = Question::create(array("section_id" => $sec_sec12->id, "name" => "Laboratory workers trained in Biosafety", "title" => "", "description" => "12.10 Are drivers/couriers and cleaners working with the laboratory trained in Biosafety practices relevant to their job tasks?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        $question_safetyOfficer = Question::create(array("section_id" => $sec_sec12->id, "name" => "Trained safety officer designated to implement and monitor the safety program ", "title" => "", "description" => "12.21 Is a trained safety officer designated to implement and monitor the safety program in the laboratory, including the training of other staff?", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "2", "one_star" => "", "user_id" => "1"));
        //  Criteria 1
        $question_controlValMonQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Control values quantitative tests", "title" => "2.1 Monitoring of Control values", "description" => "Quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_controlValMonSQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Control values semi-quantitative tests", "title" => "", "description" => "Semi-quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_controlValMonQual = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Control values qualitative tests", "title" => "", "description" => "Qualitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsMonQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Internal standards quantitative tests", "title" => "2.2 Monitoring with internal standards", "description" => "Quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsMonSQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Internal standards semi-quantitative tests", "title" => "", "description" => "Semi-quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsMonQual = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Internal standards qualitative tests", "title" => "", "description" => "Qualitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_newBatchMonQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "New batch of kits quantitative tests", "title" => "2.3 Monitoring with internal standards", "description" => "Quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_newBatchMonSQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "New batch of kits semi-quantitative tests", "title" => "", "description" => "Semi-quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_newBatchMonQual = Question::create(array("section_id" => $sec_criteria1->id, "name" => "New batch of kits qualitative tests", "title" => "", "description" => "Qualitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsKitsValMonQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Internal controls and kits validation quantitative tests", "title" => "2.4 Documentation of internal controls and kits validation", "description" => "Quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsKitsValMonSQ = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Internal controls and kits validation semi-quantitative tests", "title" => "", "description" => "Semi-quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsKitsValMonQual = Question::create(array("section_id" => $sec_criteria1->id, "name" => "Internal controls and kits validation qualitative tests", "title" => "", "description" => "Qualitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        //  Criteria 2
        /*$question_hivSer1 = Question::create(array("section_id" => $sec_criteria2->id, "name" => "Most recent HIV panel", "title" => "HIV Serology", "description" => "Most recent HIV panel", "question_type" => "1", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_hivSer2 = Question::create(array("section_id" => $sec_criteria2->id, "name" => "Internal standards semi-quantitative tests", "title" => "", "description" => "Semi-quantitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        $question_stdsMonQual = Question::create(array("section_id" => $sec_criteria2->id, "name" => "Internal standards qualitative tests", "title" => "", "description" => "Qualitative tests", "question_type" => "0", "required" => "1", "info" => "", "comment" => "", "score" => "0", "one_star" => "", "user_id" => "1"));
        */
        $this->command->info('Questions table seeded');

         /* Question-Notes */
        DB::table('question_notes')->insert(
            array("question_id" => $question_labQManual->id, "note_id" => $note_labQM->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docInfoCon->id, "note_id" => $note_docInfoControl->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_docRecords->id, "note_id" => $note_docRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_poSops->id, "note_id" => $note_poSops->id));
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
        DB::table('question_notes')->insert(
            array("question_id" => $question_workBudget->id, "note_id" => $note_workBudget->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_quaTechRecRev->id, "note_id" => $note_quaTecRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_annualQMSrev->id, "note_id" => $note_annualQMS->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_QMSImpMe->id, "note_id" => $note_qmsImp->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_commSysLabOper->id, "note_id" => $note_commSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_workSchCo->id, "note_id" => $note_workSchCo->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_duRoDaRo->id, "note_id" => $note_duRoDa->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_orgChart->id, "note_id" => $note_orgChart->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_qmsOversight->id, "note_id" => $note_qmsOversight->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_perFilSys->id, "note_id" => $note_perFiSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_staffCompAudit->id, "note_id" => $note_staffCompetency->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labStaffTra->id, "note_id" => $note_labStaffTra->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_staffMeet->id, "note_id" => $note_staffMeet->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_advTraQS->id, "note_id" => $note_adviceTra->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labHandbook->id, "note_id" => $note_labHandbook->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_commPoOnDelays->id, "note_id" => $note_commOnDelays->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_evalTool->id, "note_id" => $note_evalTool->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_properEquiPro->id, "note_id" => $note_properEquip->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipMethVal->id, "note_id" => $note_equipMethVal->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipRecMan->id, "note_id" => $note_equipRecMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipManRec->id, "note_id" => $note_equipManRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_obsoEquipPro->id, "note_id" => $note_obsoEquiPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipCalibPro->id, "note_id" => $note_equipCalibPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipPrevMan->id, "note_id" => $note_equipPreMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipSerMan->id, "note_id" => $note_equipSerMain->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipPartsRe->id, "note_id" => $note_equipPartsRep->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipMalf->id, "note_id" => $note_equipMalf->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipRepMon->id, "note_id" => $note_equipRepair->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_equipFailPlan->id, "note_id" => $note_equipFailure->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_manManual->id, "note_id" => $note_manOpManual->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_effOfQMS->id, "note_id" => $note_commEff->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_internalAudits->id, "note_id" => $note_internalAudits->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_invBudget->id, "note_id" => $note_invBudgetSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "note_id" => $note_suppPerfRev->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_manSuppList->id, "note_id" => $note_manSuppList->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_budgetaryPro->id, "note_id" => $note_budgetaryPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_orderTrack->id, "note_id" => $note_orderTrack->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_invConSys->id, "note_id" => $note_invControlSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labInvSys->id, "note_id" => $note_labInvSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_usageRateTrack->id, "note_id" => $note_usageRateTrack->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_invStockCount->id, "note_id" => $note_invStockCounts->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_storageArea->id, "note_id" => $note_storageArea->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_wastageMin->id, "note_id" => $note_invOrg->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_dispExProd->id, "note_id" => $note_disExPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_prodExpiration->id, "note_id" => $note_proEx->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_labTestServices->id, "note_id" => $note_labTestServ->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_patIdGuide->id, "note_id" => $note_speColl->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_sampRecPro->id, "note_id" => $note_sampleRecPro->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_specStoredApp->id, "note_id" => $note_specStorage->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_specPackage->id, "note_id" => $note_specPackage->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_referredSpecLog->id, "note_id" => $note_referredSpecTrack->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_procManual->id, "note_id" => $note_completeProcMan->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_reagentLogbook->id, "note_id" => $note_reagentLogbook->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_consumeVer->id, "note_id" => $note_reagentLogbook->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_inQualCo->id, "note_id" => $note_internalQC->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_qcResMon->id, "note_id" => $note_qcResMon->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_envConditons->id, "note_id" => $note_envConCheck->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_accRanges->id, "note_id" => $note_accRanges->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_externalPT->id, "note_id" => $note_extPT->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testReqResCheck->id, "note_id" => $note_testReqCheck->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testResRepSys->id, "note_id" => $note_testResRep->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testPersonnel->id, "note_id" => $note_testPersonnel->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_testResRec->id, "note_id" => $note_testResRec->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_analyticSys->id, "note_id" => $note_analyticSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_resXCheckSys->id, "note_id" => $note_resXCheckSys->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_arcDataLabel->id, "note_id" => $note_archivedData->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_backupSys->id, "note_id" => $note_infoDataBackup->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_rootCause->id, "note_id" => $note_labOccurenceRep->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_nonConfWork->id, "note_id" => $note_nonConfWork->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_nonConfAspQMS->id, "note_id" => $note_corrAction->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_discResTrack->id, "note_id" => $note_discordantResTrack->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_graphTools->id, "note_id" => $note_graphTools->id));
        DB::table('question_notes')->insert(
            array("question_id" => $question_effLabPerfImpro->id, "note_id" => $note_qIndicators->id));
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
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQStructure->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQStructure->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQPolicy->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQPolicy->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQMS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labQMS->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSProcedures->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSProcedures->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labRoles->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labRoles->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDocManReview->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labDocManReview->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_poSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSops->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_poSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecControl->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRecControl->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_confOfInterest->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_confOfInterest->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_communication->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_communication->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfContracts->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfContracts->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referralExam->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referralExam->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_purInvCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_purInvCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advisory->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advisory->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compFeedback->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_compFeedback->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConformities->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConformities->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAction->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrAction->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevAction->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevAction->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImpro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_contImpro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaTechRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaTechRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudits->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAudits->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manReview->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manReview->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persFiles->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persFiles->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persTraining->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persTraining->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_competencyAudit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_competencyAudit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Auth->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Auth->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Accomo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Accomo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Equip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_Equip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_EquiCalib->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_EquiCalib->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExamPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_preExamPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speStoRe->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speStoRe->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiVal->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiVal->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interSer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_interSer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exVal->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exVal->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaAssurance->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_quaAssurance->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resRep->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resRep->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patConf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patConf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labSafeMan->id, "answer_id" => $answer_yes->id));
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
        DB::table('question_answers')->insert(
            array("question_id" => $question_workBudget->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workBudget->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workBudget->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevActItems->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevActItems->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrActStatus->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrActStatus->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repFromPersonnel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_repFromPersonnel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workVolChange->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workVolChange->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRefRangeChange->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRefRangeChange->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cliHandbook->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cliHandbook->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_envMonLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_envMonLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speRejLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_speRejLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiCalibManRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equiCalibManRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_iqcRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_iqcRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptIntLabCo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptIntLabCo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_tatMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_tatMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qInd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qInd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recentIntAudRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recentIntAudRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extAudRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extAudRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_custCompFeed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_custCompFeed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_occIncLogs->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_occIncLogs->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impProRes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_impProRes->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_operPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_operPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabPerfEval->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refLabPerfEval->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suppPerfEval->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suppPerfEval->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docReview->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docReview->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revActPlanDoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revActPlanDoc->id, "answer_id" => $answer_no->id));

        DB::table('question_answers')->insert(
            array("question_id" => $question_annualPrevActItems->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualPrevActItems->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualCorrActStatus->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualCorrActStatus->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRepFromPersonnel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRepFromPersonnel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualWorkVolChange->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualWorkVolChange->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualBioRefRangeChange->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualBioRefRangeChange->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualCliHandbook->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualCliHandbook->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualEnvMonLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualEnvMonLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualSpeRejLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualSpeRejLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualEquiCalibManRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualEquiCalibManRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualIqcRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualIqcRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualPtIntLabCo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualPtIntLabCo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualTatMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualTatMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualQInd->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualQInd->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRecentIntAudRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRecentIntAudRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualExtAudRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualExtAudRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualCustCompFeed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualCustCompFeed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualOccIncLogs->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualOccIncLogs->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualImpProRes->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualImpProRes->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualOperPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualOperPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRefLabPerfEval->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRefLabPerfEval->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualSuppPerfEval->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualSuppPerfEval->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualDocReview->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualDocReview->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRevActPlanDoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_annualRevActPlanDoc->id, "answer_id" => $answer_no->id));

        DB::table('question_answers')->insert(
            array("question_id" => $question_QMSImpMe->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_QMSImpMe->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_QMSImpMe->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commSysLabOper->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commSysLabOper->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commSysLabOper->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workSchCo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workSchCo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_workSchCo->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_qmsOversight->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsOversight->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qmsOversight->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empOri->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empOri->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_empOri->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_educTra->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_educTra->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_educTra->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevExp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevExp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevExp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_writtenJobDesc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_writtenJobDesc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_writtenJobDesc->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_letterOfEmp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_letterOfEmp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_letterOfEmp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfJobSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfJobSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfJobSops->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRevSafetyMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRevSafetyMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docRevSafetyMan->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfProForEmp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfProForEmp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfProForEmp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_regWithProf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_regWithProf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_regWithProf->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_traRecDoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_traRecDoc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_traRecDoc->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_periodicPerfRev->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_periodicPerfRev->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_periodicPerfRev->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docEmpRecog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docEmpRecog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_docEmpRecog->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hrData->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hrData->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hrData->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffCompAudit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffCompAudit->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffCompAudit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labStaffTra->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labStaffTra->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labStaffTra->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevStaffMeet->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevStaffMeet->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prevStaffMeet->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_probCompDis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_probCompDis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_probCompDis->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfDoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfDoc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_revOfDoc->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commOnRevSops->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commOnRevSops->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_commOnRevSops->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systematicPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systematicPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_systematicPro->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_priorCorrAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_priorCorrAct->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_priorCorrAct->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discEvalOfImp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discEvalOfImp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discEvalOfImp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffFeed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffFeed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_staffFeed->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exempPerf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exempPerf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_exempPerf->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relayOfReports->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relayOfReports->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_relayOfReports->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recordMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recordMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recordMon->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advTraQS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advTraQS->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_advTraQS->id, "answer_id" => $answer_no->id));
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
        DB::table('question_answers')->insert(
            array("question_id" => $question_properEquiPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_properEquiPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_properEquiPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMethVal->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMethVal->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMethVal->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipRecMan->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipRecMan->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipRecMan->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipName->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipName->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipName->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manfCont->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manfCont->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manfCont->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_condReceived->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_condReceived->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_condReceived->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serialNo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serialNo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serialNo->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateOfPur->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateOfPur->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateOfPur->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_outOfSer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_outOfSer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_outOfSer->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateSerEntry->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateSerEntry->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_dateSerEntry->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceContInf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceContInf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceContInf->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceProCont->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceProCont->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serviceProCont->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_decontaRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_decontaRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_decontaRec->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfManRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfManRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_perfManRec->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lastSerDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lastSerDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lastSerDate->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nextSerDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nextSerDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nextSerDate->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currLoc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currLoc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_currLoc->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_obsoEquipPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_obsoEquipPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_obsoEquipPro->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipCalibPro->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipCalibPro->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipCalibPro->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_equipPartsRe->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPartsRe->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPartsRe->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMalf->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMalf->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipMalf->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipRepMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipRepMon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipRepMon->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_effOfQMS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effOfQMS->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_effOfQMS->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestSer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestSer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labTestSer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAuditCarriers->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAuditCarriers->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAuditConductor->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAuditConductor->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_causeAnalysis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_causeAnalysis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAuditFindings->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inAuditFindings->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_auditRecomm->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_auditRecomm->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_auditRecomm->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invBudget->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invBudget->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invBudget->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_serSuppPerfRev->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manSuppList->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manSuppList->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_manSuppList->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_orderTrack->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_orderTrack->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_orderTrack->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeAccRej->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeAccRej->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lotNumberRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lotNumberRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeStorage->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeStorage->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labInvSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labInvSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_labInvSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_usageRateTrack->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_usageRateTrack->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_usageRateTrack->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invStockCount->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invStockCount->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_invStockCount->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageWellOrg->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageWellOrg->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageWellOrg->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_desigPlaces->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_desigPlaces->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_desigPlaces->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardousChem->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardousChem->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardousChem->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_coldStorage->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_coldStorage->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_coldStorage->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageAreaMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageAreaMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_storageAreaMon->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ambientTemp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ambientTemp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ambientTemp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_directSunlight->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_directSunlight->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_directSunlight->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adequateVent->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adequateVent->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adequateVent->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cleanDustPests->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cleanDustPests->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_cleanDustPests->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accessControl->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accessControl->id, "answer_id" => $answer_na->id));
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
        DB::table('question_answers')->insert(
            array("question_id" => $question_patIdGuide->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patIdGuide->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patIdGuide->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLabel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLabel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLabel->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reqForm->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reqForm->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reqForm->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_afterHours->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_afterHours->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_afterHours->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_transSheet->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_transSheet->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_transSheet->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRejCrit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRejCrit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_accRejCrit->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLogged->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLogged->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specLogged->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_portions->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_portions->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_portions->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_2IdSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_2IdSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_2IdSys->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_urgentSpec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_urgentSpec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_urgentSpec->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrWorksta->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrWorksta->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_corrWorksta->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specDispSafe->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specDispSafe->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specPackage->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specStoredApp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specStoredApp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referredSpecLog->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referredSpecLog->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_referredSpecLog->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_procManual->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_procManual->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_procManual->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reagentLogbook->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reagentLogbook->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reagentLogbook->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeVer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeVer->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_consumeVer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inQualCo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inQualCo->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_inQualCo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qcResMon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qcResMon->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_qcResMon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_roomTemp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freezers->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refrigerator->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_incubators->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterBath->id, "answer_id" => $answer_yes->id));
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
            array("question_id" => $question_sampDist->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sampDist->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sampDist->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCorrAct->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCorrAct->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_ptResCorrAct->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testReqResCheck->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testReqResCheck->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testReqResCheck->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_testResRec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResRec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResRec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_analyticSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resXCheckSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resXCheckSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resXCheckSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcDataLabel->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcDataLabel->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_arcDataLabel->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_backupSys->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reportId->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_reportId->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patDemography->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_patDemography->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testRequester->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testRequester->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specTestInc->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specTestInc->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specCollDate->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_specCollDate->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRefRange->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioRefRange->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_siUnits->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_siUnits->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resInterp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resInterp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authority->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_authority->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResult->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResult->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_testResult->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_nonConfAspQMS->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConfAspQMS->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_nonConfAspQMS->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resWithheld->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_resWithheld->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recCorrect->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_recCorrect->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_approvedAuthPer->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_approvedAuthPer->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discResTrack->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discResTrack->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_discResTrack->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_graphTools->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_graphTools->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_graphTools->id, "answer_id" => $answer_no->id));
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
            array("question_id" => $question_equipPlacement->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_equipPlacement->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_neededSupplies->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_neededSupplies->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_neededSupplies->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_chairStool->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_chairStool->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_chairStool->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refMaterial->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refMaterial->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_refMaterial->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freeOfClutter->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freeOfClutter->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_freeOfClutter->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adVent->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adVent->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_adVent->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_excessMo->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_excessMo->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_excessMo->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_lit->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_climateCon->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_climateCon->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_climateCon->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_filtersChecked->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_filtersChecked->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_filtersChecked->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wireCables->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wireCables->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_wireCables->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_generator->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_generator->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_generator->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_criticalEquip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_criticalEquip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_criticalEquip->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterHazards->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterHazards->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_waterHazards->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prolongedPowerDis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prolongedPowerDis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prolongedPowerDis->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deionizedWater->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deionizedWater->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_deionizedWater->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_clericalWork->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_clericalWork->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_clericalWork->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_majSafetySignage->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_majSafetySignage->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_majSafetySignage->id, "answer_id" => $answer_na->id));
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
            array("question_id" => $question_bloboPre->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bloboPre->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardWasteDisp->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChem->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChem->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChem->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_msds->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_msds->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_msds->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persProEquip->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persProEquip->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_persProEquip->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_vaccination->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_vaccination->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_vaccination->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophylaxis->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophylaxis->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_prophylaxis->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireSafety->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireSafety->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireSafety->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecSafety->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecSafety->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecSafety->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suffWasteDisp->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suffWasteDisp->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_suffWasteDisp->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemLabeled->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemStored->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemStored->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemStored->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemUtilized->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_hazardChemDisposed->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sharpsHandled->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sharpsHandled->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_sharpsHandled->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecCords->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecCords->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_elecCords->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extinguisher->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extinguisher->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_extinguisher->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireWarning->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireWarning->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_fireWarning->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyInspec->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyInspec->id, "answer_id" => $answer_partial->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_safetyInspec->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_bioSafetyCabinets->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_centrifuge->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_centrifuge->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_centrifuge->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_handwash->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_handwash->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_handwash->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_eyewash->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_eyewash->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_eyewash->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_spillKit->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_spillKit->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_spillKit->id, "answer_id" => $answer_na->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_firstAid->id, "answer_id" => $answer_yes->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_firstAid->id, "answer_id" => $answer_no->id));
        DB::table('question_answers')->insert(
            array("question_id" => $question_firstAid->id, "answer_id" => $answer_na->id));
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
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labQStructure->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labQPolicy->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labQMS->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labSProcedures->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labRoles->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labDocManReview->id, "parent_id" => $question_labQManual->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docRecControl->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_confOfInterest->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_communication->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revOfContracts->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_referralExam->id, "parent_id" => $question_poSops->id));
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
            array("question_id" => $question_quaTechRec->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAudits->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_manReview->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_persFiles->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_persTraining->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_competencyAudit->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_Auth->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_Accomo->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_Equip->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_EquiCalib->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_preExamPro->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_speStoRe->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_exSops->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_equiVal->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_interSer->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_exVal->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_quaAssurance->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_resRep->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_patConf->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_labSafeMan->id, "parent_id" => $question_poSops->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevActItems->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrActStatus->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_repFromPersonnel->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_workVolChange->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_bioRefRangeChange->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_cliHandbook->id, "parent_id" => $question_quaTechRecRev->id));
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
            array("question_id" => $question_tatMon->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_qInd->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recentIntAudRec->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_extAudRec->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_custCompFeed->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_occIncLogs->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_impProRes->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_operPro->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refLabPerfEval->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_suppPerfEval->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docReview->id, "parent_id" => $question_quaTechRecRev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revActPlanDoc->id, "parent_id" => $question_quaTechRecRev->id));

        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualPrevActItems->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualCorrActStatus->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualRepFromPersonnel->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualWorkVolChange->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualBioRefRangeChange->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualCliHandbook->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualEnvMonLog->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualSpeRejLog->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualEquiCalibManRec->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualIqcRec->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualPtIntLabCo->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualTatMon->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualQInd->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualRecentIntAudRec->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualExtAudRec->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualCustCompFeed->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualOccIncLogs->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualImpProRes->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualOperPro->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualRefLabPerfEval->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualSuppPerfEval->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualDocReview->id, "parent_id" => $question_annualQMSrev->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_annualRevActPlanDoc->id, "parent_id" => $question_annualQMSrev->id));

        DB::table('question_parent_child')->insert(
            array("question_id" => $question_empOri->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_educTra->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevExp->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_writtenJobDesc->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_letterOfEmp->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revOfJobSops->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docRevSafetyMan->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revOfProForEmp->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_regWithProf->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_traRecDoc->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_periodicPerfRev->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_docEmpRecog->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hrData->id, "parent_id" => $question_perFilSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_prevStaffMeet->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_probCompDis->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_revOfDoc->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_commOnRevSops->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_systematicPro->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_priorCorrAct->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_discEvalOfImp->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_staffFeed->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_exempPerf->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_relayOfReports->id, "parent_id" => $question_staffMeet->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recordMon->id, "parent_id" => $question_staffMeet->id));
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
            array("question_id" => $question_serviceContInf->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_serviceProCont->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_decontaRec->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_perfManRec->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_lastSerDate->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_nextSerDate->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_currLoc->id, "parent_id" => $question_equipManRec->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAuditCarriers->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAuditConductor->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_causeAnalysis->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_inAuditFindings->id, "parent_id" => $question_internalAudits->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_consumeAccRej->id, "parent_id" => $question_invConSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_lotNumberRec->id, "parent_id" => $question_invConSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_consumeStorage->id, "parent_id" => $question_invConSys->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_storageWellOrg->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_desigPlaces->id, "parent_id" => $question_storageArea->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_hazardousChem->id, "parent_id" => $question_storageArea->id));
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
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specLabel->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_reqForm->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_afterHours->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_transSheet->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_accRejCrit->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specLogged->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_portions->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_2IdSys->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_urgentSpec->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_corrWorksta->id, "parent_id" => $question_sampRecPro->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specDispSafe->id, "parent_id" => $question_specStoredApp->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_roomTemp->id, "parent_id" => $question_envConditons->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_freezers->id, "parent_id" => $question_envConditons->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refrigerator->id, "parent_id" => $question_envConditons->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_incubators->id, "parent_id" => $question_envConditons->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_waterBath->id, "parent_id" => $question_envConditons->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_sampDist->id, "parent_id" => $question_externalPT->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptProvAccreditted->id, "parent_id" => $question_externalPT->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptSpecHandledNormally->id, "parent_id" => $question_externalPT->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptResCauseAnalysis->id, "parent_id" => $question_externalPT->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_ptResCorrAct->id, "parent_id" => $question_externalPT->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_reportId->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_patDemography->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_testRequester->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specTestInc->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_specCollDate->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_bioRefRange->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_siUnits->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_resInterp->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_authority->id, "parent_id" => $question_testResReport->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_resWithheld->id, "parent_id" => $question_nonConfAspQMS->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_recCorrect->id, "parent_id" => $question_nonConfAspQMS->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_approvedAuthPer->id, "parent_id" => $question_nonConfAspQMS->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_equipPlacement->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_neededSupplies->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_chairStool->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_refMaterial->id, "parent_id" => $question_workstationMan->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_freeOfClutter->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_adVent->id, "parent_id" => $question_phyWorkEnv->id));
        DB::table('question_parent_child')->insert(
            array("question_id" => $question_excessMo->id, "parent_id" => $question_phyWorkEnv->id));
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
            array("question_id" => $question_prolongedPowerDis->id, "parent_id" => $question_phyWorkEnv->id));
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