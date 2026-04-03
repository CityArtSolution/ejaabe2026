<?php
// app/Services/XapiService.php

namespace App\Services;

class XapiService
{
    private $endpoint;
    private $username;
    private $password;
    private $version;
   // Standard xAPI verbs
  
   const VERBS = [
    'PROGRESSED' => [
        'id' => 'http://adlnet.gov/expapi/verbs/progressed',
        'display' => [
            'en-US' => 'progressed',
            'ar-SA' => 'تقدم'
        ]
    ],
    'RATED' => [
        'id' => 'http://id.tincanapi.com/verb/rated',
        'display' => [
            'en-US' => 'rated',
            'ar-SA' => 'قيم'
        ]
    ],
    'COMPLETED' => [
        'id' => 'http://adlnet.gov/expapi/verbs/completed',
        'display' => [
            'en-US' => 'completed',
            'ar-SA' => 'أكمل'
        ]
    ],
    'ATTEMPTED' => [
        'id' => 'http://adlnet.gov/expapi/verbs/attempted',
        'display' => [
            'en-US' => 'attempted',
            'ar-SA' => 'حاول'
        ]
    ],
    'WATCHED' => [
        'id' => 'http://id.tincanapi.com/verb/watched',
        'display' => [
            'en-US' => 'watched',
            'ar-SA' => 'شاهد'
        ]
    ],
    'PAUSED' => [
        'id' => 'http://id.tincanapi.com/verb/paused',
        'display' => [
            'en-US' => 'paused',
            'ar-SA' => 'أوقف مؤقتاً'
        ]
    ]
];

    public function __construct()
    {
        $this->endpoint = env('XAPI_ENDPOINT', 'https://your-lrs-endpoint/data/xAPI/');
        $this->username = env('XAPI_USERNAME', 'your-username');
        $this->password = env('XAPI_PASSWORD', 'your-password');
        $this->version = env('XAPI_VERSION', '1.0.0');
    }

    public function sendRegistration($user, $course)
    {
        $statement = [
            'actor' => [
                'name' => $user->full_name,
                'mbox' => 'mailto:' . $user->email,
                'objectType' => 'Agent'
            ],
            'verb' => self::VERBS['REGISTERED'],
            'object' => [
                'id' => $course->getUrl(),
                'definition' => [
                    'name' => [
                        'en-US' => $course->title
                    ],
                    'description' => [
                        'en-US' => $course->description
                    ],
                    'type' => 'http://adlnet.gov/expapi/activities/course'
                ],
                'objectType' => 'Activity'
            ],
            'context' => [
                'registration' =>  $course->id,
                'platform' => config('app.name'),
                'language' => 'en-US'
            ],
            'timestamp' => date('c')
        ];

        return $this->sendStatement($statement);
    }

    public function sendInitialization($user, $course)
    {
        $statement = [
            'actor' => [
                'name' => $user->full_name,
                'mbox' => 'mailto:' . $user->email,
                'objectType' => 'Agent'
            ],
            'verb' => self::VERBS['INITIALIZED'],
            'object' => [
                'id' => $course->getUrl(),
                'definition' => [
                    'name' => [
                        'en-US' => $course->title
                    ],
                    'description' => [
                        'en-US' => $course->description
                    ],
                    'type' => 'http://adlnet.gov/expapi/activities/course'
                ],
                'objectType' => 'Activity'
            ],
            'context' => [
                'registration' =>  $course->id,
                'platform' => config('app.name'),
                'language' => 'en-US'
            ],
            'timestamp' => date('c')
        ];

        return $this->sendStatement($statement);
    }
    public function sendProgressStatement($params, $progress)
    {
        $statement = $this->createBaseStatement($params);
        $statement['verb'] = self::VERBS['PROGRESSED'];
        $statement['result'] = [
            'completion' => false,
            'extensions' => [
                'http://id.tincanapi.com/extension/progress' => $progress
            ]
        ];

        return $this->sendStatement($statement);
    }
    
public function createRateStatement($params, $rating, $response = '')
{
   
   
    $rating = round($rating /5, 2);

    // Calculate the scaled score
    $scaled = round($rating /5, 2);

      
    $statement = [
        'actor' => [
            'name' => $params['name'],
            'mbox' => 'mailto:' . $params['email']
        ],
        'verb' => [
            'id' => 'http://id.tincanapi.com/verb/rated',
            'display' => [
                'en-US' => 'rated',
                'ar-SA' => 'قيم'
            ]
        ],
        'object' => [
            'id' => $params['course_url'],
            'definition' => [
                'name' => [
                    'ar-SA' => $params['course_nameAr']
                ],
                'description' => [
                    'en-US' => $params['course_nameEn']
                ],
                'type' =>$params['type']
            ],
            'objectType' => 'Activity'
        ],
    'result' => [
            'score' => [
                'scaled' => $scaled,
                'raw' => $rating,
                'min' => 0,
                'max' => 5
            ],
            'response' =>'thanks for rating',
             'success' => true,
            'completion' => true,
           
        ],
        'context' => [
            'extensions' => [
                'https://nelc.gov.sa/extensions/platform' => [
                    'name' => [
                        'ar-SA' => 'التفاعل الايجابي  للتدريب والاستشارات',
                        'en-US' => 'Positive Interactive For Training And Consultings'
                    ]
                ],
                'http://id.tincanapi.com/extension/browser-info' => [
                    'code_name' => $params['browser'],
                    'name' => $params['browser'],
                    'version' => $params['version']
                ]
            ],
            'instructor' => [
                'name' => $params['instractor_name'],
                'mbox' => 'mailto:' . $params['instractor_email']
            ],
            'platform' => $params['platform'],
            'language' => 'ar-SA',
            'contextActivities' => [
                'parent' => [
                    [
                        'id' => $params['parent_url'],
                        'definition' => [
                            'name' => [
                                'ar-SA' => $params['course_nameAr']
                            ],
                            'description' => [
                                'en-US' => $params['course_nameEn']
                            ],
                            'type' =>$params['type']
                        ],
                        'objectType' => 'Activity'
                    ]
                ]
            ]
        ],
        'timestamp' => date('c')
    ];
        \Log::info('xAPI Statement:', $statement);


    return $this->sendStatement($statement);
}

    public function sendRatingStatement($params, $rating, $review = null)
    {
        $statement = $this->createBaseStatement($params);
        $statement['verb'] = self::VERBS['RATED'];
        $statement['result'] = [
            'score' => [
                'raw' => $rating,
                'min' => 1,
                'max' => 5,
                'scaled' => $rating / 5
            ]
        ];

        if ($review) {
            $statement['result']['extensions'] = [
                'http://id.tincanapi.com/extension/review' => $review
            ];
        }

        return $this->sendStatement($statement);
    }

    public function sendCompletionStatement($params)
    {
        $statement = $this->createBaseStatement($params);
        $statement['verb'] = self::VERBS['COMPLETED'];
        $statement['result'] = [
            'completion' => true,
            'success' => true
        ];

        return $this->sendStatement($statement);
    }

    protected function createBaseStatement($params)
    {
        return [
            'actor' => [
                'name' => $params['name'],
                'mbox' => 'mailto:' . $params['email'],
                'objectType' => 'Agent'
            ],
            'object' => [
                'id' => $params['course_url'],
                'definition' => [
                    'name' => [
                        'ar-SA' => $params['course_nameAr']
                    ],
                    'description' => [
                        'en-US' => $params['course_nameEn']
                    ],
                    'type' => $params['type']
                ],
                'objectType' => 'Activity'
            ],
            'context' => [
                'extensions' => [
                    'https://nelc.gov.sa/extensions/platform' => [
                        'name' => [
                            'ar-SA' => 'التفاعل الإيجابي للتدريب والاستشارات',
                            'en-US' => 'Ejaaabii'
                        ]
                    ],
                    'http://id.tincanapi.com/extension/browser-info' => [
                        'code_name' => $params['browser'],
                        'name' => $params['browser'],
                        'version' => $params['version']
                    ]
                ],
                'instructor' => [
                    'name' => $params['instractor_name'],
                    'mbox' => 'mailto:' . $params['instractor_email'],
                    'objectType' => 'Agent'
                ],
                'platform' => $params['platform'],
                'language' => 'ar-SA',
                'contextActivities' => [
                    'parent' => [
                        [
                            'id' => $params['parent_url'],
                            'definition' => [
                                'name' => [
                                    'ar-SA' => $params['course_nameAr']
                                ],
                                'description' => [
                                    'en-US' => $params['course_nameEn']
                                ],
                                'type' => $params['type']
                            ],
                            'objectType' => 'Activity'
                        ]
                    ]
                ]
            ],
            'timestamp' => date('c')
        ];
    }

    protected function sendStatement($statement)
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->endpoint . 'statements',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($statement),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-Experience-API-Version: ' . $this->version,
                'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password)
            ],
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception('cURL Error: ' . $error);
            
                   \Log::error('Failed to send xAPI statement: ' . $error);

        }

        return json_decode($response, true);
    }

    public function sendStatement_1($statement)
    {
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->endpoint . 'statements',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($statement),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-Experience-API-Version: ' . $this->version,
                'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password)
            ],
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception('cURL Error: ' . $error);
        }

        return json_decode($response, true);
    }

    public function createStatement($params)
    {
        $statement = [
            'actor' => [
                'name' => $params['name'],
                'mbox' => 'mailto:' . $params['email']
            ],
            'verb' => [
                'id' => 'http://adlnet.gov/expapi/verbs/' . urlencode($params['verb']),
                'display' => [
                    'en-US' => $params['verb']
                ]
            ],
            'object' => [
                'id' => $params['course_url'],
                'definition' => [
                    'name' => [
                        'ar-SA' => $params['course_nameAr']
                    ],
                    'description' => [
                        'en-US' => $params['course_nameEn']
                    ],
                    'type' => $params['type']
                ],
                'objectType' => 'Activity'
            ],
            'context' => [
                'extensions' => [
                    'https://nelc.gov.sa/extensions/platform' => [
                        'name' => [
                            'ar-SA' => 'التفاعل الايجابي  للتدريب والاستشارات',
                            'en-US' => 'Positive Ejaabi Fot Tranining And Consulting'
                        ]
                    ],
                    'http://id.tincanapi.com/extension/browser-info' => [
                        'code_name' => $params['browser'],
                        'name' => $params['browser'],
                        'version' => $params['version']
                    ]
                ],
                'instructor' => [
                    'name' => $params['instractor_name'],
                    'mbox' => 'mailto:' . $params['instractor_email']
                ],
                'platform' => $params['platform'],
                'language' => 'ar-SA',
                'contextActivities' => [
                    'parent' => [
                        [
                            'id' => $params['parent_url'],
                            'definition' => [
                                'name' => [
                                    'ar-SA' => $params['course_nameAr']
                                ],
                                'description' => [
                                    'en-US' => $params['course_nameEn']
                                ],
                                'type' =>$params['type']
                            ],
                            'objectType' => 'Activity'
                        ]
                    ]
                ]
            ],
            'timestamp' => date('c')
        ];

        return $this->sendStatement($statement);
    }


    public function createStatement_old($verb, $activity, $user, $result = null)
    {
        $statement = [
            'actor' => [
                'name' => $user->name,
                'mbox' => 'mailto:' . $user->email,
                'objectType' => 'Agent'
            ],
            'verb' => [
                'id' => $verb['id'],
                'display' => [
                    'en-US' => $verb['display']
                ]
            ],
            'object' => [
                'id' => url("/activities/{$activity->id}"),
                'definition' => [
                    'name' => [
                        'en-US' => $activity->title
                    ],
                    'description' => [
                        'en-US' => $activity->description
                    ]
                ],
                'objectType' => 'Activity'
            ],
            'timestamp' => date('c')
        ];

        if ($result) {
            $statement['result'] = $result;
        }

        return $statement;
    }
    
    
    public function createProgressStatement($params, $progress, $isCompleted)
{

   
        $scaled = $progress;

    // Construct the xAPI statement
    $statement = [
        'actor' => [
            'name' => $params['name'], // Name of the user
            'mbox' => 'mailto:' . $params['email'] // Email of the user
        ],
        'verb' => [
            'id' => 'http://id.tincanapi.com/verb/progressed', // Verb URI
            'display' => [
                'en-US' => 'progressed', // Verb display in English
                'ar-SA' => 'تقدم' // Verb display in Arabic
            ]
        ],
        'object' => [
            'id' => $params['course_url'], // URL of the course
            'definition' => [
                'name' => [
                    'ar-SA' => $params['course_nameAr'] // Course name in Arabic
                ],
                'description' => [
                    'en-US' => $params['course_nameEn'] // Course name in English
                ],
                'type' => $params['type'] // Type of activity (e.g., course)
            ],
            'objectType' => 'Activity' // Object type
        ],
        'result' => [
            'score' => [
                'scaled' => $progress // Progress as a scaled score (0.0 to 1.0)
            ],
            'completion' => $isCompleted, // Whether the activity is completed
          //  'response' => $response // Optional response or comment
        ],
        'context' => [
            'extensions' => [
                'https://nelc.gov.sa/extensions/platform' => [
                    'name' => [
                        'ar-SA' => 'التفاعل الايجابي  للتدريب والاستشارات', // Platform name in Arabic
                        'en-US' => 'Positive Interactive For Training And Consultings' // Platform name in English
                    ]
                ],
                'http://id.tincanapi.com/extension/browser-info' => [
                    'code_name' => $params['browser'], // Browser code name
                    'name' => $params['browser'], // Browser name
                    'version' => $params['version'] // Browser version
                ]
            ],
            'instructor' => [
                'name' => $params['instractor_name'], // Instructor name
                'mbox' => 'mailto:' . $params['instractor_email'] // Instructor email
            ],
            'platform' => $params['platform'], // Platform name
            'language' => 'ar-SA', // Language
            'contextActivities' => [
                'parent' => [
                    [
                        'id' => $params['parent_url'], // Parent activity URL
                        'definition' => [
                            'name' => [
                                'ar-SA' => $params['course_nameAr'] // Parent activity name in Arabic
                            ],
                            'description' => [
                                'en-US' => $params['course_nameEn'] // Parent activity name in English
                            ],
                            'type' => $params['type'] // Parent activity type
                        ],
                        'objectType' => 'Activity' // Parent object type
                    ]
                ]
            ]
        ],
        'timestamp' =>date('c') 
    ];

    // Log the statement for debugging
    \Log::info('xAPI Progress Statement:', $statement);

    // Send the statement to the xAPI endpoint
    return $this->sendStatement($statement);
}


public function createAttemptedStatement($params, $score, $isSuccess, $isCompleted)
{
    // Ensure score is within the valid range (0 to max)
    $max = $params['quiz_total_mark'];
    $score = min(max((float)$score, 0), $max);

    // Calculate the scaled score
    $scaled = round($score / $max, 2);

    $statement = [
        'actor' => [
            'name' => $params['name'], // Name of the user
            'mbox' => 'mailto:' . $params['email'] // Email of the user
        ],
        'verb' => [
            'id' => 'http://adlnet.gov/expapi/verbs/attempted', // Verb URI
            'display' => [
                'en-US' => 'attempted', // Verb display in English
                'ar-SA' => 'حاول' // Verb display in Arabic
            ]
        ],
        'object' => [
            'id' => $params['course_url'], // URL of the course
            'definition' => [
                'name' => [
                    'ar-SA' => $params['course_nameAr'] // Course name in Arabic
                ],
                'description' => [
                    'en-US' => $params['course_nameEn'] // Course name in English
                ],
                'type' => $params['type'] // Type of activity (e.g., course)
            ],
            'objectType' => 'Activity' // Object type
        ],
        'result' => [
            'score' => [
                'scaled' => $scaled, // Scaled score (e.g., 0.4 for 4/10)
                'raw' => $score, // Raw score (e.g., 4)
                'min' => 0, // Minimum possible score
                'max' => $max // Maximum possible score
            ],
            'success' => $isSuccess, // Whether the attempt was successful
            'completion' => $isCompleted, // Whether the activity is completed
            //'response' => $response // Optional response or comment
        ],
        'context' => [
            'extensions' => [
                'https://nelc.gov.sa/extensions/platform' => [
                    'name' => [
                        'ar-SA' => 'التفاعل الايجابي  للتدريب والاستشارات', // Platform name in Arabic
                        'en-US' => 'Positive Interactive For Training And Consultings' // Platform name in English
                    ]
                ],
                'http://id.tincanapi.com/extension/browser-info' => [
                    'code_name' => $params['browser'], // Browser code name
                    'name' => $params['browser'], // Browser name
                    'version' => $params['version'] // Browser version
                ],
                'http://id.tincanapi.com/extension/attempt-id' => $params['attempt_id'] // Attempt ID
            ],
            'instructor' => [
                'name' => $params['instractor_name'], // Instructor name
                'mbox' => 'mailto:' . $params['instractor_email'] // Instructor email
            ],
            'platform' => $params['platform'], // Platform name
            'language' => 'ar-SA', // Language
            'contextActivities' => [
                'parent' => [
                    [
                        'id' => $params['parent_url'], // Parent activity URL
                        'definition' => [
                            'name' => [
                                'ar-SA' => $params['course_nameAr'] // Parent activity name in Arabic
                            ],
                            'description' => [
                                'en-US' => $params['course_nameEn'] // Parent activity name in English
                            ],
                            'type' => $params['type'] // Parent activity type
                        ],
                        'objectType' => 'Activity' // Parent object type
                    ]
                ]
            ]
        ],
        'timestamp' => date('c') // Current timestamp in ISO 8601 format
    ];

    // Log the statement for debugging
    \Log::info('xAPI Attempted Statement:', $statement);

    // Send the statement to the xAPI endpoint
    return $this->sendStatement($statement);
}
     public function getBrowserInfo($userAgent)
    {
        $browser = 'Unknown';
        $version = 'Unknown';
        $platform = 'Unknown';
        $device = 'Unknown';

        // Detect browser
        if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent)) {
            $browser = 'Internet Explorer';
            $version = preg_replace('/.*MSIE\s([\d.]+).*/', '$1', $userAgent);
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
            $version = preg_replace('/.*Firefox\/([\d.]+).*/', '$1', $userAgent);
        } elseif (preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Chrome';
            $version = preg_replace('/.*Chrome\/([\d.]+).*/', '$1', $userAgent);
        } elseif (preg_match('/Safari/i', $userAgent)) {
            $browser = 'Safari';
            $version = preg_replace('/.*Version\/([\d.]+).*/', '$1', $userAgent);
        } elseif (preg_match('/Opera/i', $userAgent)) {
            $browser = 'Opera';
            $version = preg_replace('/.*Opera\/([\d.]+).*/', '$1', $userAgent);
        } elseif (preg_match('/Edge/i', $userAgent)) {
            $browser = 'Edge';
            $version = preg_replace('/.*Edge\/([\d.]+).*/', '$1', $userAgent);
        }

        // Detect platform (OS)
        if (preg_match('/Windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Macintosh|Mac OS X/i', $userAgent)) {
            $platform = 'Mac';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iOS|iPhone|iPad|iPod/i', $userAgent)) {
            $platform = 'iOS';
        }

        // Detect device type
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent)) {
            $device = 'Mobile';
        } elseif (preg_match('/Tablet|iPad/i', $userAgent)) {
            $device = 'Tablet';
        } else {
            $device = 'Desktop';
        }

        return [
            'browser' => $browser,
            'version' => $version,
            'platform' => $platform,
            'device' => $device,
        ];
    }
    
    
public function createCompletedStatement($params, $response = '')
{
    // Determine the object based on the type of completion (course or lesson)
    $object = [
        'id' => $params['activity_url'], // URL of the course or lesson
        'definition' => [
            'name' => [
                'ar-SA' => $params['activity_nameAr'] // Name in Arabic
            ],
            'description' => [
                'en-US' => $params['activity_nameEn'] // Name in English
            ],
            'type' => $params['activity_type'] // Type of activity (course or lesson)
        ],
        'objectType' => 'Activity'
    ];

    $statement = [
        'actor' => [
            'name' => $params['name'], // Name of the user
            'mbox' => 'mailto:' . $params['email'] // Email of the user
        ],
        'verb' => [
            'id' => 'http://adlnet.gov/expapi/verbs/completed', // Verb URI
            'display' => [
                'en-US' => 'completed', // Verb display in English
                'ar-SA' => 'أكمل' // Verb display in Arabic
            ]
        ],
        'object' => $object, // Dynamic object (course or lesson)
        'result' => [
            'completion' => true, // Indicates the activity is completed
            'response' => $response // Optional response or comment
        ],
        'context' => [
            'extensions' => [
                'https://nelc.gov.sa/extensions/platform' => [
                    'name' => [
                        'ar-SA' => 'التفاعل الايجابي  للتدريب والاستشارات', // Platform name in Arabic
                        'en-US' => 'Positive Interactive For Training And Consultings' // Platform name in English
                    ]
                ],
                'http://id.tincanapi.com/extension/browser-info' => [
                    'code_name' => $params['browser'], // Browser code name
                    'name' => $params['browser'], // Browser name
                    'version' => $params['version'] // Browser version
                ]
            ],
            'instructor' => [
                'name' => $params['instractor_name'], // Instructor name
                'mbox' => 'mailto:' . $params['instractor_email'] // Instructor email
            ],
            'platform' => $params['platform'], // Platform name
            'language' => 'ar-SA', // Language
            'contextActivities' => [
                'parent' => [
                    [
                        'id' => $params['parent_url'], // Parent activity URL
                        'definition' => [
                            'name' => [
                                'ar-SA' => $params['course_nameAr'] // Parent activity name in Arabic
                            ],
                            'description' => [
                                'en-US' => $params['course_nameEn'] // Parent activity name in English
                            ],
                            'type' => $params['type'] // Parent activity type
                        ],
                        'objectType' => 'Activity' // Parent object type
                    ]
                ]
            ]
        ],
        'timestamp' => date('c')// Current timestamp in ISO 8601 format
    ];

    // Log the statement for debugging
    \Log::info('xAPI Completed Statement:', $statement);

    // Send the statement to the xAPI endpoint
    return $this->sendStatement($statement);
}
public function createEarnedStatement($params)
{
    $statement = [
        'actor' => [
            'objectType' => 'Agent',
            'name' => $params['name'], // Name of the user
            'mbox' => 'mailto:' . $params['email'] // Email of the user
        ],
        'verb' => [
            'id' => 'http://id.tincanapi.com/verb/earned', // Verb URI
            'display' => [
                'en-US' => 'earned' // Verb display in English
            ]
        ],
        'object' => [
            'id' => $params['certificate_url'], // URL of the certificate
            'definition' => [
                'name' => [
                    'en-US' => $params['certificate_name'] // Certificate name in English
                ],
                'description' => [
                    'en-US' =>  $params['certificate_name'] // Certificate description in English
                ],
                'type' => 'https://www.opigno.org/en/tincan_registry/activity_type/certificate' // Certificate type
            ],
            'objectType' => 'Activity' // Object type
        ],
        'context' => [
            'extensions' => [
                'https://nelc.gov.sa/extensions/platform' => [
                    'name' => [
                        'ar-SA' => 'التفاعل الايجابي للتدريب والاستشارات', // Platform name in Arabic
                        'en-US' => 'Positive Interaction For training and Consulting' // Platform name in English
                    ]
                ],
                'http://id.tincanapi.com/extension/jws-certificate-location' => $params['certificate_image_url'], // URL of the certificate image
                'http://id.tincanapi.com/extension/browser-info' => [
                    'code_name' => $params['browser'], // Browser code name
                    'name' => $params['browser'], // Browser name
                    'version' => $params['version'] // Browser version
                ]
            ],
            'language' => 'ar-SA', // Language
            'contextActivities' => [
                'parent' => [
                    [
                        'id' => $params['course_url'], // Parent course URL
                        'definition' => [
                            'name' => [
                                'ar-SA' => $params['course_nameAr'] // Parent course name in Arabic
                            ],
                            'description' => [
                                'ar-SA' => $params['course_nameAr']  // Parent course description in Arabic
                            ],
                            'type' => 'https://w3id.org/xapi/cmi5/activitytype/course' // Parent activity type
                        ],
                        'objectType' => 'Activity' // Parent object type
                    ]
                ]
            ],
            'instructor' => [
                'objectType' => 'Agent',
                'name' => $params['instructor_name'], // Instructor name
                'mbox' => 'mailto:' . $params['instructor_email'] // Instructor email
            ],
            'platform' => $params['platform'] // Platform name
        ],
        'timestamp' =>date('c'), // Current timestamp in ISO 8601 format
        
    ];

    // Log the statement for debugging
    \Log::info('xAPI Earned Statement:', $statement);

    // Send the statement to the xAPI endpoint
    return $this->sendStatement($statement);
}



public function createVideoStatement($params, $verb)
{
    // Define the verb ID and display based on the action with updated verb URLs
    $verbDetails = [
        'played' => [
            'id' => 'https://w3id.org/xapi/video/verbs/played',
            'display' => [
                'en-US' => 'played'
            ]
        ],
        'paused' => [
            'id' => 'https://w3id.org/xapi/video/verbs/paused',
            'display' => [
                'en-US' => 'paused'
            ]
        ],
        'completed' => [
            'id' => 'http://adlnet.gov/expapi/verbs/completed',
            'display' => [
                'en-US' => 'completed'
            ]
        ]
    ];

    // Validate required parameters
    $requiredParams = ['name', 'email', 'video_url', 'video_name', 'video_length'];
    foreach ($requiredParams as $param) {
        if (!isset($params[$param])) {
            throw new \InvalidArgumentException("Missing required parameter: $param");
        }
    }

    // Ensure the verb is valid
    if (!isset($verbDetails[$verb])) {
        throw new \InvalidArgumentException("Invalid verb: $verb");
    }

    // Prepare the xAPI statement with updated extensions and proper video profile
    $statement = [
        'actor' => [
            'objectType' => 'Agent',
            'name' => $params['name'],
            'mbox' => 'mailto:' . $params['email']
        ],
        'verb' => $verbDetails[$verb],
        'object' => [
            'id' => $params['video_url'],
            'definition' => [
                'name' => [
                    'en-US' => $params['video_name']
                ],
                'description' => [
                    'en-US' => $params['video_description'] ?? ''
                ],
                'type' => 'https://w3id.org/xapi/video/activity-type/video'
            ],
            'objectType' => 'Activity'
        ],
        'context' => [
            'platform' => $params['platform'] ?? 'Web Browser',
            'language' => $params['language'] ?? 'en-US',
            'extensions' => [
                'https://w3id.org/xapi/video/extensions/length' => floatval($params['video_length']),
                'https://w3id.org/xapi/video/extensions/session-id' => $params['session_id'] ?? uniqid(),
                'https://w3id.org/xapi/video/extensions/time' => floatval($params['current_time'] ?? 0),
                'https://w3id.org/xapi/video/extensions/progress' => $this->calculateProgress($params),
            ]
        ],
        'timestamp' => now()->toIso8601String()
    ];

    // Add specific extensions based on verb
    switch ($verb) {
        case 'played':
            $statement['context']['extensions']['https://w3id.org/xapi/video/extensions/speed'] = 
                floatval($params['playback_speed'] ?? 1.0);
            break;
            
        case 'paused':
            $statement['context']['extensions']['https://w3id.org/xapi/video/extensions/time-from'] = 
                floatval($params['time_from'] ?? 0);
            break;
            
        case 'completed':
            $statement['result'] = [
                'completion' => true,
                'success' => true,
                'duration' => $this->formatDuration($params['video_length']),
                'extensions' => [
                    'https://w3id.org/xapi/video/extensions/time-watched' => 
                        floatval($params['time_watched'] ?? $params['video_length'])
                ]
            ];
            break;
    }

    // Add optional registration if provided
    if (isset($params['registration'])) {
        $statement['context']['registration'] = $params['registration'];
    }

    // Log the statement for debugging
    \Log::info('xAPI Video Statement:', $statement);

    return $this->sendStatement($statement);
}

protected function calculateProgress($params)
{
    if (isset($params['current_time']) && isset($params['video_length']) && $params['video_length'] > 0) {
        return round(($params['current_time'] / $params['video_length']) * 100, 2);
    }
    return 0;
}

protected function formatDuration($seconds)
{
    return 'PT' . number_format($seconds, 3, '.', '') . 'S';
}
   
}