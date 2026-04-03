@extends('web.default.layouts.email')

@section('body')
    <!-- content -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" dir="rtl">
        <tr>
            <td valign="top" class="bodyContent" mc:edit="body_content" style="width: 600px">
                <h1 class="h1" style="text-align: right;">{{ $notification['title'] }}</h1>
                <p style="text-align: right;">{!! nl2br($notification['message']) !!}</p>
            </td>
        </tr>
    </table>
@endsection