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
use App\Models\LabLevel;
use App\Models\LabAffiliation;
use App\Models\LabType;
use App\Models\AuditType;
use App\Models\AuditFieldGroup;
use App\Models\AuditField;
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



        //facilities
        $facilities = array(
            array("code" => "19704", "name" => "ACK Nyandarua Medical Clinic", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> "Situated within Captain township 4km from olkalou town towards NRB","nearest_town" => "Captain","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 48", "town_id" => "3", "in_charge" => "Eliud Mwangi Kithaka", "title_id" => "1", "operational_status" => "Operational", "user_id" => "1"),
            array("code" => "10039", "name" => "ACK Tumaini Medical Clinic", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Gatundu town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 84", "town_id" => "3", "in_charge" => "Assumpta", "title_id" => "1", "operational_status" => "Operational", "user_id" => "1"),
            array("code" => "17473", "name" => "ASPE Medical Clinic", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Nyeri town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 229", "town_id" => "3", "in_charge" => "Jane Mwaita", "title_id" => "1", "operational_status" => "Operational", "user_id" => "1"),
            array("code" => "11195", "name" => "Acode Medical Clinic Maungu", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Maungu town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => "P.O Box 18", "town_id" => "3", "in_charge" => "Sr  Kameru", "title_id" => "1", "operational_status" => "Operational", "user_id" => "1"),
            array("code" => "19520", "name" => "Aculaser Institute", "facility_type_id" => "13", "facility_owner_id" => "3", "description"=> " ","nearest_town" => "Westlands town","landline" => " ","fax" => " ", "mobile" => " ", "email" => "", "address" => " ", "town_id" => "3", "in_charge" => " ", "title_id" => "", "operational_status" => "Operational", "user_id" => "1")

        );
        foreach ($facilities as $facility) {
         Facility::create($facility);
        }
        $this->command->info('Facility table seeded');

        foreach ($counties as $county) {
            County::create($county);
        }
        $this->command->info('Counties table seeded');

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
        /* Audit Field groups */
        $auditFieldGroups = array(
            array("name" => "Main Page", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Part I", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Part II", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Part III", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "SLMTA Info", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Laboratory Profile", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Lab Info", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Staffing Summary", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Organization Structure", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Prelude", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 1", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 2", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 3", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 4", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 5", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 6", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 7", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 8", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 9", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 10", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 11", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Section 12", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Ethical Principles", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Criteria 1", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Criteria 2", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Summary", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "Action Plan", "audit_type_id" => "1", "user_id" => "1"),
            array("name" => "SLIPTA Certification", "audit_type_id" => "1", "user_id" => "1")
        );
        foreach ($auditFieldGroups as $auditFieldGroup) {
            AuditFieldGroup::create($auditFieldGroup);
        }
        $this->command->info('Audit field groups table seeded');
        /* Audit Field groups parent-child */
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "5", "parent_id" => "2"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "6", "parent_id" => "2"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "7", "parent_id" => "6"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "8", "parent_id" => "6"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "9", "parent_id" => "6"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "10", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "11", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "12", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "13", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "14", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "15", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "16", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "17", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "18", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "19", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "20", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "21", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "22", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "23", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "24", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "25", "parent_id" => "3"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "26", "parent_id" => "4"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "27", "parent_id" => "4"));
        DB::table('afg_parent_child')->insert(
            array("field_group_id" => "28", "parent_id" => "4"));

        $this->command->info('Audit field group parent-child seeded');

        /* Seed for Audit fields */
        $auditFields = array(
            /* Main Page */
            array("audit_field_group_id" => "1", "name" => "introduction", "label" => "1.0 INTRODUCTION", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "1", "name" => "introduction_text", "label" => "", "description" => "<p>Laboratory services are an essential component in the diagnosis and treatment of patients infected with the human immunodeficiency virus (HIV), malaria,Mycobacterium tuberculosis (TB), sexually transmitted diseases (STDs), and other infectious diseases. Presently, the laboratory infrastructure and test quality for all types of clinical laboratories remain in its nascent stages in most countries in Africa. Consequently, there is an urgent need to strengthen laboratory systems and services. The establishment of a process by which laboratories can achieve accreditation at international standards is an invaluable tool for countries to improve the quality of laboratory services. </p><p>In accordance with WHO''s core functions of setting standards and building institutional capacity, WHO-AFRO has established the Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA) to strengthen laboratory systems of its Member States. The Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA) is a framework for improving quality of public health laboratories in developing countries to achieve ISO 15189 standards. It is a process that enables laboratories to develop and document their ability to detect, identify, and promptly report all diseases of public health significance that may be present in clinical specimens. This initiative was spearheaded by a number of critical resolutions, including Resolution AFR/RC58/R2 on Public Health Laboratory Strengthening, adopted by the Member States during the 58th session of the Regional Committee in September 2008 in Yaounde, Cameroon, and the Maputo Declaration to strengthen laboratory systems. This quality improvement process towards accreditation further provides a learning opportunity and pathway for continuous improvement, a mechanism for identifying resource and training needs, a measure of progress, and a link to the WHO-AFRO National Health Laboratory Service Networks.</p><p>Clinical, public health, and reference laboratories participating in the Stepwise Laboratory Quality Improvement Process Towards Accreditation (SLIPTA) are reviewed bi-annually. Recognition is given for the upcoming calendar year based on progress towards meeting requirements set by international standards and on laboratory performance during the 12 months preceding the SLIPTA audit, relying on complete and accurate data, usually from the past 1-13 months to 1 month prior to evaluation.</p>", "comment" => "", "field_type" => "5", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "1", "name" => "scope", "label" => "2.0 Scope", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "1", "name" => "", "label" => "", "description" => "<p>This checklist specifies requirements for quality and competency aimed to develop and improve laboratory services to raise quality to established national standards. The elements of this checklist are based on ISO standard 15189:2007(E) and, to a lesser extent, CLSI guideline GP26-A4; Quality Management System: A Model for Laboratory Services; Approved Guideline—Fourth Edition.</p><p>Recognition is provided using a five star tiered approach, based on a bi-annual on-site audit of laboratory operating procedures, practices, and performance.</p><p>The inspection checklist score will correspond to the number of stars awarded to a laboratory in the following manner:<p><div class='table-responsive'><table class='table table-striped table-bordered table-hover'><tbody><tr><td><h4>No Stars</h4><p>(0 - 142 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(143 - 165 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(166 - 191 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(192 - 217 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(218 - 243 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(244 - 258 pts)</p><p><i>&ge; 95%</i></p></td></tr></tbody></table></div><p>A laboratory that achieves less than a passing score on any one of the applicable standards will work with the Regional Office Laboratory Coordinator to:</p><ul><li>Identify areas where improvement is needed.</li><li>Develop and implement a work plan.</li><li>Monitor laboratory progress.</li><li>Conduct re-testing where required.</li><li>Continue steps to achieve full accreditation.</li></ul>", "comment" => "", "field_type" => "5", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "1", "name" => "parts_of_audit", "label" => "3.0 Parts of the Audit", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "1", "name" => "parts_of_audit_text", "label" => "", "description" => "<p>This laboratory audit checklist consists of three parts:</p><h3>Part I: Laboratory Profile</h3><h3>Part II: Laboratory Audits<p><small>Evaluation of laboratory operating procedures, practices, and tables for reporting performance </small></p></h3><h3>Part III: Summary of Audit Findings<p><small>Summary of findings of the SLIPTA audit and action planning worksheet</small></p></h3>", "comment" => "", "field_type" => "5", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            /* SLMTA Information */
            array("audit_field_group_id" => "5", "name" => "slmta_infomation", "label" => "SLMTA Information", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "type_of_slmta_audit", "label" => "Type of SLMTA Audit", "description" => "", "comment" => "", "field_type" => "8", "required" => "1", "options" => "Baseline Audit, Midterm Audit, Exit Audit, Surveillance Audit, Internal Audit", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "total_tests_before_slmta", "label" => "Total # of Tests before SLMTA", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "total_tests_this_year", "label" => "Total # of tests this year", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_cohort_id", "label" => "Cohort Id", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_lab_type", "label" => "SLMTA Lab Type", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "date_of_baseline_audit", "label" => "Date of Baseline Audit", "description" => "", "comment" => "", "field_type" => "6", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "date_of_slmta_workshop_1", "label" => "Date of SLMTA workshop #1", "description" => "", "comment" => "", "field_type" => "6", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "date_of_exit_audit_performed", "label" => "Date of exit audit performed", "description" => "", "comment" => "", "field_type" => "6", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_baseline_score", "label" => "Baseline Score", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_baseline_stars_obtained", "label" => "Stars obtained", "description" => "", "comment" => "", "field_type" => "8", "required" => "", "options" => "Not Audited, 0 Stars, 1 Stars, 2 Stars, 3 Stars, 4 Stars, 5 Stars", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_exit_score", "label" => "Exit Score", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_exit_stars_obtained", "label" => "Stars obtained", "description" => "", "comment" => "", "field_type" => "8", "required" => "", "options" => "Not Audited, 0 Stars, 1 Stars, 2 Stars, 3 Stars, 4 Stars, 5 Stars", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_date_of_last_audit", "label" => "Date of Last Audit", "description" => "", "comment" => "", "field_type" => "6", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_score_for_last_audit", "label" => "Score for Last Audit", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "5", "name" => "slmta_prior_audit_status", "label" => "Prior Audit Status", "description" => "", "comment" => "", "field_type" => "8", "required" => "", "options" => "Not Audited, 0 Stars, 1 Stars, 2 Stars, 3 Stars, 4 Stars, 5 Stars", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            /* Laboratory Information */
            array("audit_field_group_id" => "7", "name" => "laboratory_information", "label" => "Laboratory Information", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "official_slipta_audit", "label" => "Official SLIPTA audit?", "description" => "", "comment" => "", "field_type" => "10", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "audit_start_date", "label" => "Audit Start Date", "description" => "", "comment" => "", "field_type" => "6", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "audit_end_date", "label" => "Audit End Date", "description" => "", "comment" => "", "field_type" => "6", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "date_of_last_audit", "label" => "Date of Last Audit", "description" => "", "comment" => "", "field_type" => "6", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "names_and_affiliations_of_auditors", "label" => "Name(s) and Affiliation(s) of Auditor(s)", "description" => "", "comment" => "", "field_type" => "9", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_name", "label" => "Laboratory Name", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_number", "label" => "Laboratory Number", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_address", "label" => "Laboratory Address", "description" => "", "comment" => "", "field_type" => "9", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_telephone", "label" => "Laboratory Telephone", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_email", "label" => "Laboratory Email", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "head_of_laboratory", "label" => "Head of Laboratory", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "telephone_of_laboratory_head", "label" => "Telephone (Head of Laboratory)", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "telephone_type", "label" => "Telephone Type", "description" => "", "comment" => "", "field_type" => "7", "required" => "1", "options" => "Personal, Work", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_level", "label" => "Laboratory Level", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            array("audit_field_group_id" => "7", "name" => "laboratory_affiliation", "label" => "Type of Laboratory/Laboratory Affiliation", "description" => "", "comment" => "", "field_type" => "3", "required" => "1", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"),
            
        );
        foreach ($auditFields as $auditField) {
            AuditField::create($auditField);
        }
        $this->command->info('Audit fields seeded');

        /* Seed for af_parent_child */
        DB::table('af_parent_child')->insert(
            array("field_id" => "2", "parent_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => "4", "parent_id" => "3", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => "6", "parent_id" => "5", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $this->command->info('Audit field parent-child seeded');
        /* Fields with parent-child */
        /* Laboratory Staffing Summary */
        $auditFieldLSS = AuditField::create(array("audit_field_group_id" => "8", "name" => "laboratory_staffing_summary", "label" => "Laboratory Staffing Summary", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldSSI = AuditField::create(array("audit_field_group_id" => "8", "name" => "staffing_summary_instruction", "label" => "Profession", "description" => "Number of Full Time Employees", "comment" => "", "field_type" => "15", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDHPS = AuditField::create(array("audit_field_group_id" => "8", "name" => "degree_holding_professional_staff", "label" => "Degree Holding Professional Staff", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDHPSA = AuditField::create(array("audit_field_group_id" => "8", "name" => "degree_holding_professional_staff_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDHS = AuditField::create(array("audit_field_group_id" => "8", "name" => "diploma_holding_professional_staff", "label" => "Diploma Holding Professional Staff", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDHSA = AuditField::create(array("audit_field_group_id" => "8", "name" => "diploma_holding_professional_staff_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldCHPS = AuditField::create(array("audit_field_group_id" => "8", "name" => "certificate_holding_professional_staff", "label" => "Certificate Holding Professional Staff", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldCHPSA = AuditField::create(array("audit_field_group_id" => "8", "name" => "certificate_holding_professional_staff_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldM = AuditField::create(array("audit_field_group_id" => "8", "name" => "microscopist", "label" => "Microscopist", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldMA = AuditField::create(array("audit_field_group_id" => "8", "name" => "microscopist_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDC = AuditField::create(array("audit_field_group_id" => "8", "name" => "data_clerk", "label" => "Data Clerk", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDCA = AuditField::create(array("audit_field_group_id" => "8", "name" => "data_clerk_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldP = AuditField::create(array("audit_field_group_id" => "8", "name" => "phlebotomist", "label" => "Phlebotomist", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldPA = AuditField::create(array("audit_field_group_id" => "8", "name" => "phlebotomist_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldC = AuditField::create(array("audit_field_group_id" => "8", "name" => "cleaner", "label" => "Cleaner", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldCA = AuditField::create(array("audit_field_group_id" => "8", "name" => "cleaner_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldCDL = AuditField::create(array("audit_field_group_id" => "8", "name" => "cleaner_dedicated_for_laboratory", "label" => "Is the cleaner(s) dedicated for only laboratory?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldCTS = AuditField::create(array("audit_field_group_id" => "8", "name" => "cleaner_trained_in_safe_waste_handling", "label" => "Has the cleaner(s) been trained in safe waste handling?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldD = AuditField::create(array("audit_field_group_id" => "8", "name" => "driver", "label" => "Driver", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDA = AuditField::create(array("audit_field_group_id" => "8", "name" => "driver_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDDL = AuditField::create(array("audit_field_group_id" => "8", "name" => "driver_dedicated_for_laboratory", "label" => "Is the driver(s) dedicated for only laboratory?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldDTB = AuditField::create(array("audit_field_group_id" => "8", "name" => "driver_trained_in_biosafety", "label" => "Has the driver(s) been trained in biosafety?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldO = AuditField::create(array("audit_field_group_id" => "8", "name" => "other_staff", "label" => "Other", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldOA = AuditField::create(array("audit_field_group_id" => "8", "name" => "other_staff_adequate", "label" => "Adequate for facility operations?", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No, Insufficient data", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldLSSN = AuditField::create(array("audit_field_group_id" => "8", "name" => "laboratory_staffing_summary_note", "label" => "", "description" => "If the laboratory has IT specialists accountants or non-laboratory-trained management staff, this should be indicated in the description of the organizational structure on the following page.", "comment" => "", "field_type" => "1", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $this->command->info('Laboratory Staffing Summary seeded');
        /* Seed for af_parent_child - Laboratory Staffing Summary */
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldSSI->id, "parent_id" => $auditFieldLSS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDHPSA->id, "parent_id" => $auditFieldDHPS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDHSA->id, "parent_id" => $auditFieldDHS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCHPSA->id, "parent_id" => $auditFieldCHPS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldMA->id, "parent_id" => $auditFieldM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDCA->id, "parent_id" => $auditFieldDC->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPA->id, "parent_id" => $auditFieldP->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCA->id, "parent_id" => $auditFieldC->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCDL->id, "parent_id" => $auditFieldC->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCTS->id, "parent_id" => $auditFieldC->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDA->id, "parent_id" => $auditFieldD->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDDL->id, "parent_id" => $auditFieldD->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDTB->id, "parent_id" => $auditFieldD->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldOA->id, "parent_id" => $auditFieldO->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $this->command->info('Laboratory Staffing Summary parent-child seeded');
        /* Organizational Structure */
        $auditFieldOrgS = AuditField::create(array("audit_field_group_id" => "9", "name" => "organizational_structure", "label" => "Organizational Structure", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldOrgSI = AuditField::create(array("audit_field_group_id" => "9", "name" => "organizational_structure_instruction", "label" => "", "description" => "Does the laboratory have sufficient space, equipment, supplies, personnel, infrastructure, etc. to execute the correct and timely performance of each test and maintain the quality management system? If no, please elaborate in the summary and recommendations section at the end of the checklist.", "comment" => "", "field_type" => "1", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldSuffS = AuditField::create(array("audit_field_group_id" => "9", "name" => "sufficient_space", "label" => "Sufficient space", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldEquip = AuditField::create(array("audit_field_group_id" => "9", "name" => "equipment", "label" => "Equipment", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldSupp = AuditField::create(array("audit_field_group_id" => "9", "name" => "supplies", "label" => "Supplies", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldPer = AuditField::create(array("audit_field_group_id" => "9", "name" => "personnel", "label" => "Personnel", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldInfra = AuditField::create(array("audit_field_group_id" => "9", "name" => "infrastructure", "label" => "Infrastructure", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldOrgSO = AuditField::create(array("audit_field_group_id" => "9", "name" => "organizational_structure_other", "label" => "Other - Please specify:", "description" => "", "comment" => "", "field_type" => "3", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldOrgSOS = AuditField::create(array("audit_field_group_id" => "9", "name" => "organizational_structure_other_sufficient", "label" => "Other - Please specify:", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $this->command->info('Organizational Structure seeded');
        /* Seed for af_parent_child - Organizational Structure */
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldOrgSI->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldSuffS->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldEquip->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldSupp->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPer->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldInfra->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldOrgSO->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldOrgSOS->id, "parent_id" => $auditFieldOrgS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $this->command->info('Organizational Structure parent-child seeded');
        /* Prelude */
        $auditFieldPrelude = AuditField::create(array("audit_field_group_id" => "10", "name" => "prelude", "label" => "PART II: LABORATORY AUDITS", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldPreludeTxt = AuditField::create(array("audit_field_group_id" => "10", "name" => "prelude_text", "label" => "", "description" => "<p>Laboratory audits are an effective means to 1) determine if a laboratory is providing accurate and reliable results; 2) determine if the laboratory is well-managed and is adhering to good laboratory practices; and 3) identify areas for improvement. </p><p>Auditors complete this audit using the methods below to evaluate laboratory operations per checklist items and to document findings in detail.</p><ul><li><strong>Review laboratory records &nbsp;</strong>to verify that the laboratory quality manual, policies, personnel files, equipment maintenance records; audit trails, incident reports, logs, Standard Operating Procedures (SOPs) and other manuals (e.g., safety manual) are complete, current, accurate, and annually reviewed.</li><li><strong>Observe laboratory operations &nbsp;</strong>to ensure: <ul><li>Laboratory testing follows written policies and procedures in pre-analytic, analytic and post-analytic phases of laboratory testing;</li><li>Laboratory procedures are appropriate for the testing performed;</li><li>Deficiencies and nonconformities identified are adequately investigated and resolved within the established timeframe.</li></ul></li><li><strong>Ask open-ended questions &nbsp;</strong>to clarify documentation seen and observations made. Ask questions like, \"show me how...\" or \"tell me about...\" It is often not necessary to ask all the checklist questions verbatim. An experienced auditor can often learn to answer multiple checklist questions through open-ended questions with the laboratory staff.</li><li><strong>Follow a specimen through the laboratory &nbsp;</strong>from collection through registration, preparation, aliquoting, analyzing, result verification, reporting, printing, and post-analytic handling and storing samples to determine the strength of laboratory systems and operations.</li><li><strong>Confirm that each result or batch can be traced &nbsp;</strong>back to a corresponding internal quality control (IQC) run and that the IQC was passed. Confirm that IQC results are recorded for all IQC runs and reviewed for validation.</li><li><strong>Confirm PT results &nbsp;</strong>and the results are reviewed and corrective action taken as required.</li><li><strong>Evaluate the quality and efficiency of supporting work areas &nbsp;</strong>(e.g., phlebotomy, data registration and reception, messengers, drivers, cleaners, IT, etc).</li><li><strong>Talk to clinicians &nbsp;</strong>to learn the users' perspective on the laboratory's performance. Clinicians often are a good source of information regarding the quality and efficiency of the laboratory. Notable findings can be documented in the Summary and Recommendations section at the end of the checklist.</li></ul>", "comment" => "", "field_type" => "5", "required" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldAS = AuditField::create(array("audit_field_group_id" => "10", "name" => "audit_scoring", "label" => "AUDIT SCORING", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldAST = AuditField::create(array("audit_field_group_id" => "10", "name" => "audit_scoring_text", "label" => "", "description" => "<p>This Stepwise Laboratory Quality Improvement Process Towards Accreditation Checklist contains 111 main sections (a total of 334 questions) for a total of 258 points. Each item has been awarded a point value of 2, 3, 4 or 5 points--based upon relative importance and/or complexity. Responses to all questions must be, \"yes\", \"partial\", or \"no\".</p><ul><li>Items marked \"yes\" receive the corresponding point value (2, 3, 4 or 5 points).<strong><u>All</u> elements of a question must be present in order to indicate \"yes\" for a given item and thus award the corresponding points.</strong><p><strong>NOTE:</strong> items that include \"tick lists\" must receive all \"yes\" and/or \"n/a\" responses to be marked \"yes\" for the overarching item.</p></li><li>Items marked <i>\"partial\"</i> receive 1 point.</li><li>Items marked <i>\"no\"</i> receive 0 points.</li></ul><p>When marking \"partial\" or \"no\", notes should be written in the comments field to explain why the laboratory did not fulfill this item to assist the laboratory with addressing these areas of identified need following the audit.</p>", "comment" => "", "field_type" => "5", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $auditFieldASTT = AuditField::create(array("audit_field_group_id" => "10", "name" => "audit_scoring_tables", "label" => "", "description" => "<div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td colspan=\"2\"><strong>Audit Score Sheet</strong></td></tr><tr><td><i>Section</i></td><td><i>Total Points</i></td></tr><tr><td><strong>Section 1 &nbsp;<strong>Documents & Records</td><td><strong>25</strong></td></tr><tr><td><strong>Section 2 &nbsp;<strong>Management Reviews</td><td><strong>12</strong></td></tr><tr><td><strong>Section 3 &nbsp;<strong>Organization & Personnel</td><td><strong>22</strong></td></tr><tr><td><strong>Section 4 &nbsp;<strong>Client Management & Customer Service</td><td><strong>8</strong></td></tr><tr><td><strong>Section 5 &nbsp;<strong>Equipment</td><td><strong>33</strong></td></tr><tr><td><strong>Section 6 &nbsp;<strong>Purchasing & Inventory</td><td><strong>10</strong></td></tr><tr><td><strong>Section 7 &nbsp;<strong>Purchasing & Inventory</td><td><strong>30</strong></td></tr><tr><td><strong>Section 8 &nbsp;<strong>Process Control and Internal & External Quality Audit</td><td><strong>14</strong></td></tr><tr><td><strong>Section 9 &nbsp;<strong>Information Management</td><td><strong>43</strong></td></tr><tr><td><strong>Section 10 &nbsp;<strong>Corrective Action</td><td><strong>8</strong></td></tr><tr><td><strong>Section 11 &nbsp;<strong>Occurrence/Incident Management & Process Improvement</td><td><strong>10</strong></td></tr><tr><td><strong>Section 12 &nbsp;<strong>Facilities and Safety</td><td><strong>43</strong></td></tr><tr><td><strong>TOTAL SCORE<strong></td><td><strong>258</strong></td></tr></tbody></table></div><div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td><h4>No Stars</h4><p>(0 - 142 pts)</p><p><i>&lt; 55%</i></p></td><td><h4>1 Star</h4><p>(143 - 165 pts)</p><p><i>55 - 64%</i></p></td><td><h4>2 Stars</h4><p>(166 - 191 pts)</p><p><i>65 - 74%</i></p></td><td><h4>3 Stars</h4><p>(192 - 217 pts)</p><p><i>75 - 84%</i></p></td><td><h4>4 Stars</h4><p>(218 - 243 pts)</p><p><i>85 - 94%</i></p></td><td><h4>5 Stars</h4><p>(244 - 258 pts)</p><p><i>≥ 95%</i></p></td></tr></tbody></table></div>", "comment" => "", "field_type" => "5", "required" => "", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1","created_at" => "2015-03-31 09:05:01", "updated_at" => "2015-03-31 09:05:01"));
        $this->command->info('Prelude seeded');
        /* Seed for af_parent_child - Prelude */
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPreludeTxt->id, "parent_id" => $auditFieldPrelude->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldAST->id, "parent_id" => $auditFieldAS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldASTT->id, "parent_id" => $auditFieldAS->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $this->command->info('Prelude parent-child seeded');

        /* Douments and Records */
        $auditFieldSec1Inst = AuditField::create(array("audit_field_group_id" => "11", "name" => "sec_1_instruction", "label" => "", "description" => "For each item, please circle either Yes (Y), Partial (P), or No (N). All elements of the question must be satisfactorily present to indicate \"yes\". Provide explanation or further comments for each \"partial\" or \"no\" response.", "comment" => "", "field_type" => "1", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldSec1Head = AuditField::create(array("audit_field_group_id" => "11", "name" => "sec_1_heading", "label" => "1.0 DOCUMENTS AND RECORDS", "description" => "", "comment" => "", "field_type" => "0", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQM = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_manual", "label" => "1.1 Laboratory Quality Manual", "description" => "Is there a current laboratory quality manual, composed of the quality management system’s policies and procedures, and has the manual content been communicated to and understood and implemented by all staff?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "", "iso" => "ISO 15189: 4.2.3, 4.2.4", "score" => "4", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQMi = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_manual_instruction", "label" => "Tick for each item", "description" => "The quality manual includes the following elements:", "comment" => "", "field_type" => "14", "required" => "", "textarea" => "", "options" => "Yes(Y), No(N)", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQMs = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_manual_structure", "label" => "1.1.1 Structure defined per ISO15189, Section 4.2.4", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQPs = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_policy_statement", "label" => "1.1.2 Quality policy statement that includes scope of service, standard of service, objectives of the quality management system, and management commitment to compliance", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQManS = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_management_system", "label" => "1.1.3 Description of the quality management system and the structure of its documentation", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQSPro = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_supporting_procedures", "label" => "1.1.4 Reference to supporting procedures, including technical procedures", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldRoRe = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_roles_and_responsibilities", "label" => "1.1.5 Description of the roles and responsibilities of the laboratory manager, quality manager, and other personnel responsible for ensuring compliance", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQDoc = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_doumentation", "label" => "1.1.6 Documentation of at least annual management review and approval.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> A quality manual should be available that summarizes the laboratory''s quality program, includes policies that address all areas of the laboratory service, and identifies the goals and objectives of the quality program. The quality manual should include policies (processes and procedures) for all areas of the laboratory service and should address all of the quality system essentials (QSE).<br /><strong>ISO 15189: 4.2.3, 4.2.4</strong></small></i>", "comment" => "", "field_type" => "13", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));

        $auditFieldDocInfoCon = AuditField::create(array("audit_field_group_id" => "11", "name" => "document_and_information_control", "label" => "1.2 Document and Information Control System', 'Does the laboratory have a system in place to control all documents and information (internal and external sources)?", "description" => "", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDocInfoConStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "document_and_information_control_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> A document control system should be in place to ensure that records and all copies of policies/procedures are current, read by personnel, authorized by proper authorities, reviewed annually, and immediately prior versions filed separately as per national policy. There must be a procedure/policy on document control. Documents must be uniquely identified to include title, page numbers, and authority of issue, document number, versions, effective date, and author. There must be a procedure/policy on document control. Documents must be uniquely identified to include tile, page numbers, and authority of issue, document number, versions, effective date, and author.<br /><strong>ISO 15189: 4.3.1, 4.3.2, 4.3.3</strong></small></i>", "comment" => "", "field_type" => "13", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDocRec = AuditField::create(array("audit_field_group_id" => "11", "name" => "documents_and_records", "label" => "1.3 Document and Records", "description" => "Are documents and records properly maintained, easily accessible and fully detailed in an up-to-date Master List?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDocRecStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "documents_and_records_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> A document control system should be in place to ensure that records and all copies of policies/procedures are current, read by personnel, authorized by proper authorities, reviewed annually, and immediately prior versions filed separately as per national policy. There must be a procedure/policy on document control. Documents must be uniquely identified to include title, page numbers, and authority of issue, document number, versions, effective date, and author. There must be a procedure/policy on document control. Documents must be uniquely identified to include tile, page numbers, and authority of issue, document number, versions, effective date, and author.<br /><strong>ISO 15189: 4.3.1, 4.3.2, 4.3.3</strong></small></i>", "comment" => "", "field_type" => "13", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPoSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "policies_and_sops", "label" => "1.4 Laboratory Policies and Standard Operating Procedures", "description" => "Are policies and standard operating procedures (SOPs) for laboratory functions current, available and approved by authorized personnel?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "", "iso" => "ISO 15189 4.3.2", "score" => "5", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        
        $auditFieldPoSopsI = AuditField::create(array("audit_field_group_id" => "11", "name" => "policies_and_sops_instruction", "label" => "Tick for each item", "description" => "Policies and/or SOPs that:", "comment" => "", "field_type" => "14", "required" => "", "textarea" => "", "options" => "Yes(Y), No(N)", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDocRecSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "documents_and_records_sops", "label" => "1.4.1 Document & Record Control: Defines the writing, checking, authorization, review, identification, amendments, control & communication of revisions to and retention & safe disposal of all documents and records.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard ISO15189: 4.3.1, 4.13.1-3", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldConISops = AuditField::create(array("audit_field_group_id" => "11", "name" => "conflict_of_interest_sops", "label" => "1.4.2 Conflict of Interest: Defines the systems in place to identify and avoid potential conflicts of interest and commercial, financial, political or other pressures that may affect the quality and integrity of operations", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO15189: 4.1", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldCommSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "communication_sops", "label" => "1.4.3 Communication: Defines the systems in place to ensure effectiveness of the quality management systems", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO15189: 4.1.6", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldRevConSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "review_of_contracts_sops", "label" => "1.4.4 Review of Contracts (Supplier and Customer): Defines the maintenance of all records, original requests, inquiries, verbal discussions and requests for additional examinations, meetings, and meeting minutes.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.4", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldRefLabSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "referral_laboratories_sops", "label" => "1.4.5 Examination by Referral Laboratories: Defines the 1) evaluation, selection, and performance monitoring of referral laboratories, 2) packaging and tracking of referred samples, 3) and reporting of results from referral labs", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.5.1", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldInvConSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "purchasing_and_inventory_control_sops", "label" => "1.4.6 Purchasing and Inventory Control: Defines the processes for 1) requesting, ordering and receipt of supplies, 2) the selection of approved suppliers, 3) acceptance/rejection criteria for purchased items, 4) safe handling; 5) storage; inventory control system; 6) monitoring and handling of expired consumables", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.6", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldAdvSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "advisory_services_sops", "label" => "1.4.7 Advisory Services: Defines the required qualifications and responsibility for providing advice on: 1) choice of examinations; 2) the use of the services; 3) repeat frequency; 4) required type of sample; 5) interpretation of results; and 6) maintenance of records of communication with lab users", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 4.7", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldComFeeSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "complaints_and_feedback_sops", "label" => "1.4.8 Resolution of Complaints and Feedback: Defines how 1) complaints and feedback shall be recorded, 2) steps to determine whether patient’s results have been compromised, 3) investigative and corrective actions taken as required, 4) timeframe for closure and feedback to the complainant", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.8", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldNonConSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "control_of_nonconformities_sops", "label" => "1.4.9 Identification and Control of Nonconformities: Defines the 1) types of nonconformities that could be identified, 2) how/where to record, 3) who is responsible for problem resolution; 4) when examinations are to be halted, 5) the recall of released results and 6) person responsible for authorizing release of results after corrective action has been taken", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.9", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldCorActSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "corrective_action_sops", "label" => "1.4.10 Corrective Action: Defines 1) where to record, 2) how to perform root cause analysis, 3) who will be responsible for implementing action plans within the stipulated timeframes, and 4) monitoring the effectiveness of these actions in overcoming the identified problems.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.10", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPreActSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "preventive_action_sops", "label" => "1.4.11 Preventive Action: Defines what tools will be used, where the action plan will be recorded, who will be responsible for ensuring the implementation within an agreed time frame and the monitoring of its effectiveness", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.11", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldConImpSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "continual_improvement_sops", "label" => "1.4.12 Continual Improvement: Defines what quality indicators will be used and how action plans for these areas will be recorded, evaluated, and reviewed for effectiveness of improvement", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.12", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldTecRecSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_and_technical_records_sops", "label" => "1.4.13 Quality and Technical Records: Defines what are quality and technical records, how amendments would be done, traceability, storage, retention and accessibility of all hard and electronic records", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.13", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldIntAudSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "internal_audits_sops", "label" => "1.4.14 Internal Audits: Defines the internal audit process, including roles and responsibilities, types of audits, frequency of audits, auditing forms to be used, what will be covered, and identification of personnel responsible for ensuring closure of any nonconformances raised within the agreed timeframe and effectiveness of corrective actions implemented.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.14", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldManRevSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "management_review_sops", "label" => "1.4.15 Management Review: Defines frequency, agenda (in line with 4.15.2 a-m), key attendees required, and plan that will include goals, objectives, action plans, responsibilities, due dates and how decisions/actions taken will be communicated to the relevant persons", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 4.15", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPerRecSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "personal_records_sops", "label" => "1.4.16 Personnel Records/Files: Defines organizational plan, personnel policies, what is required in a personnel file (minimum in line with ISO 15189 Section 5.1.2) and location of personnel files", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 5.1", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPerTraSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "personnel_training_sops", "label" => "1.4.17 Personnel Training: Defines staff appraisals, staff orientation, initial training, refresher training, continuous education program, recommended and required trainings, and record-keeping of training", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 5.1.4, 5.1.6, 5.1.9", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldComAudSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "competency_audit_sops", "label" => "1.4.18 Competency audit: Defines the methods, ongoing competency testing and training, and criteria used to assess competency of personnel", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 5.1.11", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldAuthSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "authorization_sops", "label" => "1.4.19 Authorization: Defines the level of authorization for all tasks, roles and deputies for all staff", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 5.1.7", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldEnvConSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "environmental_conditions_sops", "label" => "1.4.20 Accommodation and Environmental Conditions: Defines any specific environmental and accommodation requirements, and the responsibility, monitoring, controlling, and recording of these requirements.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 5.2.5", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldEquiSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "equipment_sops", "label" => "1.4.21 Equipment: Defines what records are to be maintained in equipment file, the minimum information required on equipment label; action to be taken for defective equipment and maintenance frequency; and access control", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "Standard: ISO 15189: 5.3", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldCalibSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "calibration_of_equipment_sops", "label" => "1.4.22 Calibration of Equipment: Defines frequency; the use of reference standards where applicable; what is required on the calibration label or calibration record and what action to be taken if calibration fails", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.3", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPreExSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "preexamination_sops", "label" => "1.4.23 Pre-examination Procedures (Handbook): Defines Specimen Collection, sample and volume requirements; unique identification, special handling; minimum requirements for completion of a requisition form, transportation and receipt of samples", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.4.2,5.4.3", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldSpeStoSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "specimen_storage_sops", "label" => "1.4.24 Specimen Storage and Retention: Defines pre- and post-sampling storage conditions, stability and retention times", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.7.2", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldExaSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "examination_sops", "label" => "1.4.25 Examination SOPs: Defines all sub-clauses of ISO15189 Section 5.5.3 (a-q)", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.5.3", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldEquiValSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "equipment_validation_sops", "label" => "1.4.26 Equipment Validation/Verification: Defines methods to be used, how the lab ensures that equipment taken out of the control from the lab is checked and shown to be functioning satisfactorily before being returned to laboratory use, validation/verification acceptance criteria and person responsible for final authorization for intended use", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.5.2", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldIntSerSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "interrupted_services_sops", "label" => "1.4.27 Interrupted Services: Defines backup procedures for equipment failure, power failure, unavailability of consumables and other resources", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldExValSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "examination_validation_sops", "label" => "1.4.28 Examination Validation/Verification: Defines methods to be used, acceptance criteria, and person responsible for final authorization for intended use", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.5.2", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldQASops = AuditField::create(array("audit_field_group_id" => "11", "name" => "quality_assurance_sops", "label" => "1.4.29 Quality Assurance: Defines the use of IQC and EQC, setting up of ranges, monitoring performance and troubleshooting guidelines", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189 5.6", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldRepResSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "reporting_of_results_sops", "label" => "1.4.30 Reporting of Results: Defines the standardized format of a report (in line with ISO15189: Section 5.8.3), methods of communication, release of results to authorized persons, alteration of reports and reissuance of amended reports.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.8", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPatConSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "patient_confidentiality_sops", "label" => "1.4.31 Patient Confidentiality: Defines the tools used to ensure patient confidentiality and access control to laboratory facilities and records (electronic and paper records)", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15189: 5.8.13", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldLabSafSops = AuditField::create(array("audit_field_group_id" => "11", "name" => "laboratory_safety_sops", "label" => "1.4.32 Laboratory Safety or Safety Manual: Defines the contents to be included.", "description" => "", "comment" => "", "field_type" => "7", "required" => "", "textarea" => "1", "options" => "Yes, No", "iso" => "ISO 15190: 7.5", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldSopStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "sops_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> Standard Operating Procedures (SOPs) should be established and maintained up-to-date for all tasks performed within the laboratory, safety and waste disposal, document control, specimen collection and processing, inventory control, procurement, and quality assurance. SOPs should be reviewed for accuracy and relevance on an annual basis. All policies and procedures should be approved by an authorized person.</small></i>", "comment" => "", "field_type" => "13", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        
        $auditFieldPoSopA = AuditField::create(array("audit_field_group_id" => "11", "name" => "policy_and_sops_accessibility", "label" => "1.5 Policy and SOPs Accessibility", "description" => "Are policies and SOPs easily accessible/ available to all staff and written in a language commonly understood by respective staff?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPoSopAStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "policy_and_sops_accessibility_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> All procedures shall be documented and be available at the workstation for relevant staff. Documented procedures and necessary instructions shall be available in a language commonly understood by the staff in the laboratory.<br /><strong>ISO 15189: 5.5.3, 4.3.2 Part C</strong></small></i>", "comment" => "", "field_type" => "", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPoSopComm = AuditField::create(array("audit_field_group_id" => "11", "name" => "policy_and_sops_communication", "label" => "1.6 Policies and SOPs Communication", "description" => "Is there documented evidence that all relevant policies and SOPs have been communicated to and are understood and implemented by all staff as related to their responsibilities?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldPoSopCommStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "policy_and_sops_communication_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> Policies, processes, programs, procedures and instructions shall be documented and communicated to all relevant staff and management must ensure that these documents are understood by staff and implemented.<br /><strong>ISO 15189: 4.2.1</strong></small></i>", "comment" => "", "field_type" => "", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDocConLog = AuditField::create(array("audit_field_group_id" => "11", "name" => "document_and_control_log", "label" => "1.7 Document Control Log", "description" => "Are policies and procedures dated to reflect when it was put into effect and when it was discontinued?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDocConLogStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "document_and_control_log_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> The document control log or other documentation should capture the date the policy/procedure went into service, schedule of review, the identity of the reviewers, and the date of discontinuation.<br /><strong>ISO 15189: 4.3.1, 4.3.2 Part (e) and (f): 4.3.2 - </strong>\"Procedures shall be adopted to ensure that e) invalid or obsolete documents are promptly removed from all points of use, or otherwise assured against inadvertent use; and f) retained or archived superseded documents are appropriately identified to prevent their inadvertent use.\"</small></i>", "comment" => "", "field_type" => "", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDiscP = AuditField::create(array("audit_field_group_id" => "11", "name" => "discontinued_policies_and_sops", "label" => "1.8 Discontinued Policies and SOPs", "description" => "Are invalid or discontinued policies and procedures removed from use and retained or archived for the time period required by lab and/or national policy?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDiscPStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "discontinued_policies_and_sops_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> Discontinued policies/procedures should be retained or archived in a separate file or place clearly marked to avoid use for the period of time required by laboratory and/or national policy.<br /><strong>ISO 15189: 4.3.1, 4.3.2 Part (e) and (f) - see above</strong></small></i>", "comment" => "", "field_type" => "", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDataF = AuditField::create(array("audit_field_group_id" => "11", "name" => "data_files", "label" => "1.9 Data Files", "description" => "Are test results and technical and quality records archived in accordance with national/international guidelines?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldDataFStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "data_files_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> Copies or files of results should be archived. The length of time that reported data are retained may vary; however, the reported results shall be retrievable for as long as medically relevant or as required by national, regional or local requirements.<br /><strong>ISO 15189: 5.8.6, 4.13.2, 4.13.3</strong></small></i>", "comment" => "", "field_type" => "", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldArchResA = AuditField::create(array("audit_field_group_id" => "11", "name" => "archived_results_accessibility", "label" => "1.10 Archived Results Accessibility", "description" => "Are archived records and results easily retrievable in a timely manner?", "comment" => "", "field_type" => "11", "required" => "", "textarea" => "", "options" => "Yes, Partial, No", "iso" => "", "score" => "2", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $auditFieldArchResAStd = AuditField::create(array("audit_field_group_id" => "11", "name" => "archived_results_accessibility_standard", "label" => "", "description" => "<i><small><strong>Standard:</strong> Archived patient results must be easily, readily, and completely retrievable within a timeframe consistent with patient care needs.<br /><strong>ISO 15189: 5.8.6, 4.13.2</strong></small></i>", "comment" => "", "field_type" => "", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        
        $auditFieldDocRecSub = AuditField::create(array("audit_field_group_id" => "11", "name" => "documents_and_records_subtotal", "label" => "", "description" => "<div class=\"table-responsive\"><table class=\"table table-striped table-bordered table-hover\"><tbody><tr><td width=\"50%\"><strong>SECTION 1: DOCUMENTS & RECORDS Subtotal</strong></td><td><div class=\"col-sm-3\"><div class=\"form-group input-group\"><input type=\"text\" class=\"form-control\"><span class=\"input-group-addon\">/25</span></div></div></td></tr></tbody></table></div>", "comment" => "", "field_type" => "5", "required" => "", "textarea" => "", "options" => "", "iso" => "", "score" => "0", "user_id" => "1", "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        
        $this->command->info('Douments and Records seeded');
        /* Seed for af_parent_child - Douments and Records */
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQM->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQMi->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQMs->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQPs->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQManS->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQSPro->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldRoRe->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQDoc->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQStd->id, "parent_id" => $auditFieldQM->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocInfoCon->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocInfoConStd->id, "parent_id" => $auditFieldDocInfoCon->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocRec->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocRecStd->id, "parent_id" => $auditFieldDocRec->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPoSops->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPoSopsI->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocRecSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldConISops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCommSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldRevConSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldRefLabSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldInvConSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldAdvSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldComFeeSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldNonConSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCorActSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPreActSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldConImpSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldTecRecSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldIntAudSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldManRevSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPerRecSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPerTraSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldComAudSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldAuthSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldEnvConSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldEquiSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldCalibSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPreExSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldSpeStoSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldExaSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldEquiValSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldIntSerSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldExValSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldQASops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldRepResSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPatConSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldLabSafSops->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldSopStd->id, "parent_id" => $auditFieldPoSops->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPoSopA->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPoSopAStd->id, "parent_id" => $auditFieldPoSopA->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPoSopComm->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldPoSopCommStd->id, "parent_id" => $auditFieldPoSopComm->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocConLog->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocConLogStd->id, "parent_id" => $auditFieldDocConLog->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDiscP->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDiscPStd->id, "parent_id" => $auditFieldDiscP->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDataF->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDataFStd->id, "parent_id" => $auditFieldDataF->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldArchResA->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldArchResAStd->id, "parent_id" => $auditFieldArchResA->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        DB::table('af_parent_child')->insert(
            array("field_id" => $auditFieldDocRecSub->id, "parent_id" => $auditFieldSec1Head->id, "created_at" => "2015-04-01 06:01:38", "updated_at" => "2015-04-01 06:01:38"));
        $this->command->info('Douments and Records parent-child seeded');
    }
}