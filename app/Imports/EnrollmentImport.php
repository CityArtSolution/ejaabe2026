<?php

namespace App\Imports;

use App\User;
use App\Models\Sale;
use App\Models\Webinar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Services\XapiService;

class EnrollmentImport implements ToCollection, WithHeadingRow
{
    protected $results = [
        'success' => 0,
        'failed' => 0,
        'created' => 0,
        'updated' => 0,
        'errors' => []
    ];
         protected $xapiService;

    public function __construct(XapiService $xapiService)
    {
        $this->xapiService = $xapiService;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (empty($row['email'])) {
                $this->results['errors'][] = "Row skipped: Email is missing";
                $this->results['failed']++;
                continue;
            }

            try {
               /* $role_name='users';  
                 $role_id=1;
                if( $row['role_name']!='admin' ){
                    
                    $role_name=$row['role_name'];
                   
                }
                
                 if( $row['role_id']!='2' ){
                    
                    $role_id=$row['role_id'];
                   
                }*/
                   $org_id=NULL;
               if(auth()->user()->isOrganization()){
                   
                 $org_id=auth()->user()->id;
                   
               }

               
                // Find or create user
                $user = User::updateOrCreate(
                    ['email' => $row['email']],
                    [
                        'full_name' => $row['full_name'] ?? '',
                        'password' => isset($row['password']) ? Hash::make($row['password']) : Hash::make('default123'),
                        'role_id' =>/*$role_id*/ 1, 
                        'role_name' =>/*$role_name*/ 'user', 
                        'mobile' => $row['mobile'] ?? null,
                        'status'=>'active',
                        'verified'>=1,
                        'organ_id'=>$org_id,
                         'created_at' => time()
                    ]
                );

                $wasRecentlyCreated = $user->wasRecentlyCreated;
                if ($wasRecentlyCreated) {
                    $this->results['created']++;
                } else {
                    $this->results['updated']++;
                }

                // Handle webinar enrollment if webinar_id exists in the row
                if (!empty($row['webinar_id'])) {
                    $course = Webinar::find($row['webinar_id']);
                    
                    if (!$course) {
                        $this->results['errors'][] = "Course ID {$row['webinar_id']} not found for user {$row['email']}";
                        $this->results['failed']++;
                        continue;
                    }

                    // Check if user is the owner
                    if ($course->isOwner($user->id)) {
                        $this->results['errors'][] = "User {$user->email} is owner of course {$course->title}";
                        $this->results['failed']++;
                        continue;
                    }

                    // Check if already enrolled
                    if ($course->checkUserHasBought($user)) {
                        $this->results['errors'][] = "User {$user->email} already enrolled in {$course->title}";
                        $this->results['failed']++;
                        continue;
                    }

                    // Create the enrollment
                    Sale::create([
                        'buyer_id' => $user->id,
                        'seller_id' => $course->creator_id,
                        'webinar_id' => $course->id,
                        'type' => Sale::$webinar,
                        'manual_added' => true,
                        'payment_method' => Sale::$credit,
                        'amount' => 0,
                        'total_amount' => 0,
                        'created_at' => time(),
                    ]);
                    
                    
                    
                    


            $agent = $_SERVER['HTTP_USER_AGENT'];
            $browserInfo = $this->xapiService->getBrowserInfo($agent);

              $params = [
                  'name' => $user->full_name,
                  'email' => $user->email,
                  'verb' => 'registered', // or any other verb
                  'course_url' => $course->getUrl(),
                  'course_nameAr' => $course->title,
                  'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                  'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                  'browser' =>$browserInfo['browser'],
                  'version' =>$browserInfo['version'],
                  'platform' => 'EJAABI',
                  'instractor_name' =>$course->teacher->full_name,
                  'instractor_email' => $course->teacher->email,
                  'parent_url' => $course->getUrl(),
              ];

      //registred verb
              $this->xapiService->createStatement($params);
              $params = [
                  'name' => $user->full_name,
                  'email' => $user->email,
                  'verb' => 'initialized', // or any other verb
                  'course_url' => $course->getUrl(),
                  'course_nameAr' => $course->title,
                  'course_nameEn' =>$course->getTranslation('title','en')->title ?? $course->title,
                  'type' => 'https://w3id.org/xapi/cmi5/activitytype/course',
                  'browser' =>$browserInfo['browser'],
                  'version' =>$browserInfo['version'],
                  'platform' => 'EJAABI',
                  'instractor_name' =>$course->teacher->full_name,
                  'instractor_email' => $course->teacher->email,
                  'parent_url' => $course->getUrl(),
              ];
              //initailized  course
              $this->xapiService->createStatement($params);
            
                    
                    
                    
                    
                    

                    $this->results['success']++;
                }
            } catch (\Exception $e) {
                
                dd($e->getMessage());
                $this->results['errors'][] = "Error processing row for {$row['email']}: " . $e->getMessage();
                $this->results['failed']++;
            }
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}