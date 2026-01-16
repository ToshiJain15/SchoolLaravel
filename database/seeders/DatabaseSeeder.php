<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // verify roles exist, if not seed them (though migration does it)
        if(DB::table('roles')->count() == 0) {
             DB::table('roles')->insert([
                ['name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Teacher', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Student', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Parent', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Users
        // Check if admin exists to avoid duplication errors if unique index exists
        if (!DB::table('users')->where('email', 'admin@school.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'Admin User',
                'email' => 'admin@school.com',
                'password' => Hash::make('password'), // password
                'role_id' => 1, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        if (!DB::table('users')->where('email', 'student@school.com')->exists()) {
             DB::table('users')->insert([
                'name' => 'Student User',
                'email' => 'student@school.com',
                'password' => Hash::make('password'),
                'role_id' => 3, // Student
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Classes
        $classes = ['Class 1', 'Class 2', 'Class 3', 'Class 4', 'Class 5', 'Class 6', 'Class 7', 'Class 8', 'Class 9', 'Class 10'];
        foreach ($classes as $class) {
            DB::table('classes')->updateOrInsert(['name' => $class], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $classIds = DB::table('classes')->pluck('id')->toArray();

        // Cities
        $cities = ['New York', 'London', 'Paris', 'Tokyo', 'Mumbai', 'Delhi'];
        foreach ($cities as $city) {
            DB::table('cities')->updateOrInsert(['name' => $city], [
                 'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Occupations
        $occupations = ['Engineer', 'Doctor', 'Artist', 'Student', 'Teacher', 'Lawyer'];
        foreach ($occupations as $occupation) {
             DB::table('occupations')->updateOrInsert(['name' => $occupation], [
                 'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Subjects
        $subjects = ['Mathematics', 'Science', 'English', 'History', 'Geography', 'Physics', 'Chemistry'];
        foreach ($subjects as $sub) {
            DB::table('subjects')->updateOrInsert(['name' => $sub], [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        $subjectIds = DB::table('subjects')->pluck('id')->toArray();

        // Students
        // We will seed 20 random students if table is empty
        if (DB::table('students')->count() < 20) {
            for ($i = 1; $i <= 20; $i++) {
                DB::table('students')->insert([
                    'name' => 'Student ' . Str::random(5),
                    'class_id' => $classIds[array_rand($classIds)],
                    'address' => '123 Fake Street, City ' . $i,
                    'hobbies' => 'Reading, Gaming',
                    'gender' => ($i % 2 == 0) ? 'Female' : 'Male',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        // Exams
        if (DB::table('exams')->count() == 0) {
            foreach($classIds as $cId) {
                // Create an exam for each class
                $examId = DB::table('exams')->insertGetId([
                    'name' => 'Mid Term Exam - ' . DB::table('classes')->where('id', $cId)->value('name'),
                    'class_id' => $cId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Attach subjects to exam
                if (!empty($subjectIds)) {
                    foreach(array_slice($subjectIds, 0, 4) as $subId) {
                         DB::table('exam_subjects')->insert([
                            'exam_id' => $examId,
                            'subject_id' => $subId,
                            'max_marks' => 100,
                            'total' => 40, // Passing marks
                            'created_at' => now(),
                            'updated_at' => now(),
                         ]);
                    }
                }
            }
        }
        // Student Marks (exam_students)
        if (DB::table('exam_students')->count() == 0) {
            $students = DB::table('students')->get();
            foreach ($students as $student) {
                // Find exams for this student's class
                $exams = DB::table('exams')->where('class_id', $student->class_id)->get();
                foreach ($exams as $exam) {
                    // Find subjects for this exam
                    $examSubjects = DB::table('exam_subjects')->where('exam_id', $exam->id)->get();
                    foreach ($examSubjects as $es) {
                        // Insert random marks (20 to 95)
                        DB::table('exam_students')->insert([
                            'exam_id' => $exam->id,
                            'subject_id' => $es->subject_id,
                            'student_id' => $student->id,
                            'marks' => rand(20, 95),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
