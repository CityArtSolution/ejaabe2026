<?php

namespace App\Imports;

use App\User;
use App\Models\Sale;
use App\Models\Webinar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrollmentImport implements ToCollection, WithHeadingRow
{
    protected $webinarIds;
    protected $results = [
        'success' => 0,
        'failed' => 0,
        'errors' => []
    ];

    public function __construct(array $webinarIds)
    {
        $this->webinarIds = $webinarIds;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Check if email exists in the row
            if (empty($row['email'])) {
                $this->results['errors'][] = "Row skipped: Email is missing";
                $this->results['failed']++;
                continue;
            }

            // Find or skip user
            $user = User::where('email', $row['email'])->first();
            if (!$user) {
                $this->results['errors'][] = "User not found for email: {$row['email']}";
                $this->results['failed']++;
                continue;
            }

            // Enroll in each selected course
            foreach ($this->webinarIds as $webinarId) {
                $course = Webinar::find($webinarId);
                
                if (!$course) {
                    $this->results['errors'][] = "Course ID {$webinarId} not found";
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

                try {
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

                    $this->results['success']++;
                } catch (\Exception $e) {
                    $this->results['errors'][] = "Error enrolling {$user->email} in course {$course->title}: " . $e->getMessage();
                    $this->results['failed']++;
                }
            }
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}