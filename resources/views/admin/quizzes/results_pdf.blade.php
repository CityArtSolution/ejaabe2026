<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results</title>

    <style>
  

        body {
            font-family:"XBRiyaz", serif !important;
            direction: rtl; /* RTL support */
        }
       
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: right; /* Align text to the right for RTL */
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding-bottom:5px;
            border-bottom: 1px solid #dad9d9;
        }
        .header .logo {
            width: 100px; /* Adjust logo size as needed */
          
        }
        .header .info {
            text-align: left;
            font-family: "XBRiyaz", serif;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="https://ejaabi.com/public/uploads/main/images/09-12-2023/657400958cf84.png" alt="Logo">
        </div>
              
    </div>
    <table>
        <thead>
            <tr>
                <th class="text-left">{{ trans('admin/main.title') }}</th>
                <th class="text-left">المجموعة</th>
                <th class="text-left">الجهة</th>
                <th class="text-center">التاريخ</th>

                <th class="text-left">اسم المتدرب</th>
                <th class="text-left">رقم المتدرب</th>
                <th class="text-left">عدد المحاولات</th>

                <th class="text-center">الدرجة</th>
                <th class="text-center">المحاولة</th>
           
            </tr>
        </thead>
        <tbody>
            @foreach($quizzesResults as $result)
            <tr>
                <td>
                    <span>{{ $result->quiz->title }}</span>
                    <small class="d-block text-left text-primary">({{ $result->quiz->webinar->title }})</small>
                </td>

                <td class="text-left">
                    @if($result->user->getUserGroup())
                    {{ $result->user->getUserGroup()->first()->name ?? "" }}
                    @endif

                </td>
                <td>
             {{$result->user->organization->full_name ?? ""}}

                </td>
                <td class="text-center">{{ dateTimeformat($result->created_at, 'j F Y') }}</td>

                <td class="text-left">{{ $result->user->full_name }}
                   

                </td>
                <td class="text-left">{{ $result->user->id }}</td>
                <td>{{$result->attempt_count ?? ""}}</td>
                <td class="text-center">{{ $result->max_grade }}</td>
               <td class="text-center">
                <a href="/panel/quizzes/{{$result->max_grade_result_id}}/result">رابط المحاولة</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>