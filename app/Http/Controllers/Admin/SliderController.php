<?php

namespace Corp\Http\Controllers\Admin;

use Corp\Http\Requests\SliderRequest;
use Corp\Repositories\SliderRepository;
use Corp\Slider;
use Illuminate\Http\Request;
use Corp\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class SliderController extends AdminController
{
    public function __construct(SliderRepository $s_rep)
    {
        parent::__construct();

        $this->s_rep = $s_rep;
        $this->template = 'admin.general';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('view', new Slider())) {
//            abort(403);
            $key = 'custom.VIEW_ADMIN_SLIDERS';
            return ['error' => 'У вас нет прав на ' . mb_strtolower(trans($key))];
        }

        $this->title = "Управление слайдом";

        $sliders = $this->getSliders();

        $this->content_view = view(config('settings.theme') . '.admin.sliders_content')
            ->with(['sliders' => $sliders])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
/*        if (Gate::denies('create', new Slider())) {
            abort(403);
        }*/

        $this->title = "Добавление нового слайда";

        $cutouts = $this->getСuttouts();
        $positions = $this->getPositions();
        $this->content_view = view(config('settings.theme') . '.admin.sliders_edit_content')
            ->with(['positions' => $positions, 'cutouts' => $cutouts])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SliderRequest $request)
    {
        $result = $this->s_rep->addSlider($request);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.sliders.index')->with($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
   /*     if (Gate::denies('update', $slider)) {
            abort(403);
        }*/

        $this->title = "Редактирование материала – №" . $slider->id;

        $cutouts = $this->getСuttouts();
        $positions = $this->getPositions();
        $this->content_view = view(config('settings.theme') . '.admin.sliders_edit_content')
            ->with(['slider' => $slider, 'positions' => $positions, 'cutouts' => $cutouts])
            ->render();

        return $this->renderOutput();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        $result = $this->s_rep->updateSlider($request, $slider);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.sliders.index')->with($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        $result = $this->s_rep->deleteSlider($slider);

        if (is_array($result) && !empty($result['error'])) {
            return back()->with($result);
        }
        return redirect()->route('admin.sliders.index')->with($result);
    }


    protected function getSliders()
    {
        $sliders = $this->s_rep->get(['id', 'img', 'desc', 'title', 'position']);

        if ($sliders->isEmpty()) {
            return false;
        }

        $sliders->transform(function ($item) {
            $obj = new \stdClass();
            $obj->value = $item->position;
            switch ($item->position) {
                case 2:
                    $obj->text = 'Нижний правый угол';
                    $obj->class = 'slider-bottom-right';
                    break;
                case 3:
                    $obj->text = 'Нижний левый угол';
                    $obj->class = 'slider-bottom-left';
                    break;
                case 4:
                    $obj->text = 'Верхний левый угол';
                    $obj->class = 'slider-top-left';
                    break;
                case 1:
                default:
                    $obj->text = 'Верхний правый угол';
                    $obj->class = 'slider-top-right';
            }
            $item->position = $obj;

            return $item;
        });

        return $sliders;
    }

    public function getPositions()
    {
        return ['1' => 'Верхний правый угол',
            '2' => 'Нижний правый угол',
            '3' => 'Нижний левый угол',
            '4' => 'Верхний левый угол'
        ];
    }

    public function getСuttouts()
    {
        return ['top-left' => 'Верхний левый угол',
            'top' => 'Верх',
            'top-right' => 'Верхний правый угол',
            'left' => 'Левая сторона',
            'center' => 'Центр',
            'right' => 'Правая сторона',
            'bottom-left' => 'Нижний левый угол',
            'bottom' => 'Низ',
            'bottom-right' => 'Нижний правый угол'
        ];
    }
}
