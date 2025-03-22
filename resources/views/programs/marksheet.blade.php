<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Malaysian Skills Certification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            background-color: #ffffff;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo {
            width: 100px;
            height: 100px;
            background-color: #e6f2ff;
            margin: 0 auto;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #003366;
        }

        h1,
        h2 {
            color: #003366;
            margin: 10px 0;
        }

        h1 {
            font-size: 24px;
        }

        h2 {
            font-size: 18px;
        }

        .competency-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .competency-table th,
        .competency-table td {
            border: 1px solid #003366;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        .competency-table th {
            background-color: #003366;
            color: white;
            border: 1px solid black;
        }

        .general-credit-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .general-credit-table th,
        .general-credit-table td {
            border: 1px solid #003366;
            padding: 8px;
            text-align: center;
            font-size: 14px;
        }

        .general-credit-table th {
            background-color: #003366;
            color: white;
            border: 1px solid black;
        }

        .total-section {
            width: 50%;

        }

        .total-section table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-section th,
        .total-section td {
            border: 1px solid #003366;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }


        .footer {
            text-align: right;
            width: 45%;
            float: right;
            font-size: 9px;
            margin-top: -20%;
        }

        .signature {
            margin-top: 15px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('public/uploads/settings/logo.png') }}" alt="SG Akademi Logo" class="img-fluid">
        <h1>SG AKADEMI</h1>
        <h2>MALAYSIAN SKILLS CERTIFICATION (SKM) Level 3</h2>
    </div>

    <table>
        <tr>
            <th style="text-align: left;">ACCREDITATION CENTER(AC)</th>
            <td>: {{ $student->academic ? $student->academic->title : 'N/A' }}({{$student->academic ? $student->academic->year : 'N/A'}})</td>

        </tr>
        <tr>
            <th style="text-align: left;">NAME</th>
            <td>: {{ $student->student ? $student->student->full_name : 'N/A' }}</td>
        </tr>
        <tr>
            <th style="text-align: left;">CLASS</th>
            <td>: {{ $student->class->class_name  }}</td>
        </tr>

        <tr>
            <th style="text-align: left;">LEVEL</th>
            <td>: {{ $student->section->section_name }}</td>
        </tr>
        <tr>
            <th style="text-align: left;">Admission No</th>
            <td>: {{ $student->student->admission_no }}</td>
        </tr>
        <tr>
            <th style="text-align: left;">Roll NO</th>
            <td>: {{ $student->student->roll_no  }}</td>
        </tr>

        <tr>
            <th style="text-align: left;">START DATE</th>
            <td>: {{ $student->academic ? $student->academic->starting_date : 'N/A' }}</td>
        </tr>
        <tr>
            <th style="text-align: left;">END DATE</th>
            <td>: {{ $student->academic ? $student->academic->ending_date : 'N/A' }}</td>
        </tr>
    </table>
    <b>
        <hr>
    </b>


    <!-- <h3>GENERAL CREDIT</h3> -->
    <table class="general-credit-table">
        <thead>
            <tr>
                <th>SL</th>
                <th>SUBJECT</th>
                <th>MARK</th>
                <th>GRADE</th>
                <th>PERCENTAGE</th>
                <th>RESULT</th>
            </tr>
        </thead>

        @php
        $overallFailCount = 0;
        @endphp

        @foreach($subjects as $subjectId => $subjectData)
        @php
        $totalMarks = 0;
        $totalGpaGrade = 0;

        if (!empty($subjectData['lesson_totals'])) {
        foreach ($subjectData['lesson_totals'] as $lessonTotal) {
        $totalMarks = $lessonTotal['total_marks'];
        $totalGpaGrade = $lessonTotal['total_gpa_grade'];
        }
        }

        $result = $subjectData['result']; // Assuming each subject has a 'result' field

        // Check if this subject has a fail
        if ($result === 'fail') {
        $overallFailCount++;
        }
        @endphp
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $subjectData['subject']->subject_name }}</td>
            <td>{{ $totalMarks }}</td>
            <td>{{ $totalGpaGrade }}</td>
            <td>{{ $subjectData['total_percentage_point'] }}</td>
            <td>{{ ucfirst($result) }}</td>
        </tr>
        @endforeach
    </table>

    <h3>TOTAL MARKS : </h3>
    <div class="clearfix">
        <div class="total-section">
            <table>
                <tr>
                    <th>TOTAL MARKS</th>
                    <td>{{ $totals['totalMarks'] }}</td>
                </tr>
                <tr>
                    <th>TOTAL GRADE VALUE</th>
                    <td>{{ $totals['totalGradeValue'] }}</td>
                </tr>
                <tr>
                    <th>PERCENTAGE</th>
                    <td>{{ $totals['totalPercentage'] }}%</td>
                </tr>
                <tr>
                    <th>RESULT</th>
                    <td class="result">
                        @if($overallFailCount > 0)
                        Fail
                        @else
                        Pass
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Verified by:</p>
        <div class="signature">____________________</div>
        <p>PN RU'AIN BINTI KU AHMAD ZAMRI</p>
        <p>CENTER MANAGER</p>
        <p>SG Akademi (M) Sdn. Bhd. (682879-M)</p>
    </div>
    </div>
</body>

</html>