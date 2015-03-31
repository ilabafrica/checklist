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
    }
}