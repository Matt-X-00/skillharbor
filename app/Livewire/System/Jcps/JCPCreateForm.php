<?php

namespace App\Livewire\System\Jcps;

use Livewire\Component;
use App\Models\Audit\jcp;
use App\Models\Audit\qualification;
use App\Models\Audit\skill;
use Illuminate\Http\Client\Request;

class JCPCreateForm extends Component
{
    public $currentPage = 1;
    public $position_title = '';
    public $duty_station = '';
    public $job_grade = '';
    public $job_purpose = '';
    public $is_active = '';
    public $jcp_qualifications = [];
    public $jcp_skills = [];

    public function mount(){
        $this->jcp_skills = [
            []
        ];
    }

     // Page information
     public $pages = [
        1 => [
            'title' => 'Job Competency Profile Information',
            'description' => 'Make sure the information you enter coresponds to the Job Description.',
        ],
        2 => [
            'title' => 'Prerequisite Information',
            'description' => 'Enter the information regarding required qualifications,certifications and/or licenses.',
        ],
        3 => [
            'title' => 'Skills Information',
            'description' => 'Enter the information regarding required skills and abilities.',
        ],

    ];

    public function nextPage()
    {
        $this->ValidateForm();
        $this->currentPage++;
    }

    public function previousPage()
    {
        $this->currentPage--;
    }

    public function addSkill(){
        $this->jcp_skills[] = ['skill_id' => '', 'required_rating' => 1];
    }
    public function removeSkill($index){
        unset($this->jcp_skills[$index]);
        array_values($this->jcp_skills);
    }

    public function save()
    {
        $jcp = jcp::create([
            'position_title' => $this->position_title,
            'duty_station' => $this->duty_station,
            'job_grade' => $this->job_grade,
            'job_purpose' => $this->job_purpose,
            'is_active' => $this->is_active,
            //Add Frontend for these elements
            'user_id' => 1,
            'assessment_id' => 1
        ]);

        foreach ($this->jcp_qualifications as $qualId) {
            // Attach the qualification to the jcp-qualifications pivot table
            $jcp->qualifications()->attach($qualId);
        }
        foreach ($this->jcp_skills as $skill_id => $required_rating) {
            // Attach the qualification to the jcp-qualifications pivot table
            $jcp->skills()->attach($skill_id, ['required_rating' => $required_rating]);
        }

        session()->flash('status', 'JCP successfully created.');

        return $this->redirect('/jcp');
    }

    public function ValidateForm(){
        if($this->currentPage === 1){


        }elseif($this->currentPage === 2){

        }
    }



    public function render()
    {
        return view('livewire.system.jcps.j-c-p-create-form',['qualifications' => qualification::all(), 'skills' => skill::all(),]);
    }
}
