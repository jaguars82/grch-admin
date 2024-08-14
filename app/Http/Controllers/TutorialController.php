<?php

namespace App\Http\Controllers;

use App\Models\Agregator\Lesson;
use App\Models\Agregator\LessonCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $lessons = Lesson::orderBy('sort_order', 'asc')->get();

        return Inertia::render('Information/Tutorial/Index', [
            'lessons' => $lessons,
        ]);
    }

    /**
     * Show the form for creating a new lesson.
     *
     * @return \Inertia\Response
     */
    public function createLesson(Request $request)
    {
        if ($request->isMethod('post')) {

            $validatedData = $request->validate(Lesson::validationRules());
            
            $lesson = new Lesson;

            $lesson->fill($validatedData);

            $lesson->sort_order = Lesson::getCount() + 1;
            $lesson->videohosting_type = $this->detectVideohostingByUrl($lesson->video_source);

            $lesson->save();

            return redirect()->route('tutorial-index');
        }

        return Inertia::render('Information/Tutorial/Lesson/Create');
    }

    /**
     * Show the form for udating the lesson.
     */
    public function updateLesson(Request $request)
    {
        $lesson = Lesson::find($request->input('id'));

        if ($request->isMethod('post')) {

            $validatedData = $request->validate(Lesson::validationRules());
            
            $lesson->fill($validatedData);
            $lesson->videohosting_type = $this->detectVideohostingByUrl($lesson->video_source);

            $lesson->save();

            return redirect()->route('tutorial-index');
        }

        return Inertia::render('Information/Tutorial/Lesson/Update', [
            'lesson' => $lesson,
        ]);
    }

     /**
     * Reoder lessons
     */
    public function reoderLessons(Request $request)
    {
        $orderInList = 1;

        foreach ($request->input('lessons') as $item) {
            $lesson = Lesson::find($item['id']);
            $lesson->sort_order = $orderInList;
            $lesson->save();
            $orderInList++;
        }

        return redirect()->route('tutorial-index');
    }

    /**
     * Show the form for udating the lesson.
     */
    public function deleteLesson(Request $request)
    {
        $lesson = Lesson::find($request->input('id'));
        $lesson->delete();

        // Re-ordering the rest of the lessons
        $lessons = Lesson::orderBy('sort_order', 'asc')->get();

        $orderInList = 1;

        foreach ($lessons as $lesson) {
            $lesson->sort_order = $orderInList;
            $lesson->save();
            $orderInList++;
        }

        return redirect()->route('tutorial-index');
    }

    private function detectVideohostingByUrl ($url)
    {
        if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
            return Lesson::HOSTING_YOUTUBE;
        } elseif (strpos($url, 'rutube.ru') !== false) {
            return Lesson::HOSTING_RUTUBE;
        } elseif (strpos($url, 'vk.com') !== false) {
            return Lesson::HOSTING_VKVIDEO;
        } else {
            return Lesson::HOSTING_LOCAL;
        }
    }

}
