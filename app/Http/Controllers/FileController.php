<?php

namespace App\Http\Controllers;

use Excel;
use App\Room;
use App\User;
use App\Course;
use App\Section;
use App\Subject;
use App\UserSubject;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class FileController extends Controller
{
    private $excel;

    public function __construct(Excel $excel) {
        $this->excel = $excel;
    }

    public function export()
    {
        $users = User::all();

        // map to string property values
        $users = collect($users)->map(function ($value) {
            return [
                'id' => (string) $value->id,
                'name' => $value->name
            ];
        });

        return Excel::download(new UsersExport($users), 'invoices.csv');
    }

    public function importStudents(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file' 
        ]);
        
        $path = Input::file('file')->getRealPath();
        $students = Excel::load($path, function($reader) {
        })->get();

        $studentCollection = collect($students);

        foreach ($students as $key => $student) {
            $userCount = User::count();
            if ($key <= 800) {
                $isRegistered = User::where('student_id', $student->studentid)->first();
                if (!$isRegistered) {
    
                    // if course doesn't exist then create
                    $course = Course::firstOrCreate([
                        'name' => $student->coursecode
                    ]);
    
                    $section = Section::where('code', $student->sectioncode)->first();
                    if (!$section) {
                        $section = Section::firstOrCreate([
                            'code' => $student->sectioncode
                        ]);
                    }
    
                    $room = Room::where('name', $student->roomcode)->first();
                    if (!$room && $student->roomcode) {
                        $room = Room::firstOrCreate([
                            'name' => $student->roomcode
                        ]);
                    }
    
                    $instructor = User::where('instructor_id', $student->instructorid)->first();
                    if (!$instructor && $student->instructorid) {
                        // create instructor
                        $instructor = User::firstOrCreate([
                            'instructor_id' => $student->instructorid,
                            'first_name' => $student->teacherfname,
                            'last_name' => $student->teaherlname,
                            'gender' => 'Male',
                            // for user account
                            'email' => removeSpaces(strtolower($student->teacherfname . $student->teaherlname)) . '@gmail.com',
                            'password' => bcrypt('test123'),
                            'role' => 'instructor',
                            'active' => true
                        ]);
                    }
    
                    $subject = Subject::where('code', $student->subjectcode)->first();
                    if (!$subject) {
                        $subject = Subject::firstOrCreate([
                            'code' => $student->subjectcode,
                            'description' => $student->description,
                            'is_lab' => $student->islab,
                            'units' => $student->totalunits,
                            'time_start' => $student->timebegin,
                            'time_end' => $student->timeend,
                            'day_code' => $student->daycode,
                            'room_id' => optional($room)->id,
                            'instructor_id' => optional($instructor)->id,
                            'section_id' => optional($section)->id
                        ]);
                    }
    
                    // create student
                    $studentEmail = removeSpaces(strtolower($student->firstname . $student->lastname)) . '@gmail.com';
                    $userStudent = User::where('email', $studentEmail)->first();
                    if (!$userStudent && !$student->instructorid) {
                        $user = User::firstOrCreate([
                            'student_id' => $student->studentid,
                            'first_name' => $student->firstname,
                            'middle_name' => $student->middlename,
                            'last_name' => $student->lastname,
                            'gender' => $student->sex,
                            'status' => $student->status,
                            'course_id' => $course->id,
                            'year_level' => $student->yearlevel,
                            // for user account
                            'email' => $studentEmail,
                            'password' => bcrypt('test123'),
                            'role' => 'student',
                            'active' => true
                        ]);
                    }
                }
            }
        }

        $users = User::where('role', 'student')->get();

        foreach ($users as $users_key => $user_record) {

            $student_id = $user_record->student_id;
            $filtered = $studentCollection->filter(function ($value, $key) use($student_id) {
                return $value['studentid'] == $student_id;
            })->all();

            foreach($filtered as $k => $filteredRecord) {
                $subjectId = optional(Subject::where('code', $filteredRecord['subjectcode'])->first())->id;
                $sectionId = optional(Section::where('code', $filteredRecord['sectioncode'])->first())->id;
                if ($subjectId && $sectionId) {
                    UserSubject::firstOrCreate([
                        'user_id' => $user_record->id,
                        'subject_id' => $subjectId,
                        'section_id' => $sectionId,
                        'semester_id' => $request->has('semester_id') ? $request->get('semester_id') : 1
                    ]);
                }
            }
            
        }
    }
}


function removeSpaces(string $string)
{
    return str_replace(' ', '', $string);
}