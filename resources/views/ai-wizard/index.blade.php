@extends('layouts.app')

@section('title', 'AI Wizard - Marahin Aja')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">
    <div class="max-w-md w-full">
        @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="glass rounded-xl p-6 md:p-8 mb-12">
            <form id="wizardForm" action="{{ route('ai-wizard.recommendations') }}" method="POST">
                @csrf
                
                <!-- Questions appear one at a time -->
                
                <!-- Question 1: Gender -->
                <div class="wizard-step-content" data-step="1">
                    <div class="question-container">
                        <div class="flex flex-col gap-4 w-full max-w-xs mx-auto">
                            <label class="gender-option flex items-center p-5 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-ye-accent hover:shadow-lg transition-all">
                                <input type="radio" name="gender" value="male" class="sr-only question-input" required>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-gender-male mr-4" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M9.5 2a.5.5 0 0 1 0-1h5a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0V2.707L9.871 6.836a5 5 0 1 1-.707-.707L13.293 2zM6 6a4 4 0 1 0 0 8 4 4 0 0 0 0-8"/>
                                </svg>
                                <span class="text-lg font-medium">Laki-laki</span>
                            </label>
                            <label class="gender-option flex items-center p-5 border-2 border-gray-300 rounded-xl cursor-pointer hover:border-ye-accent hover:shadow-lg transition-all">
                                <input type="radio" name="gender" value="female" class="sr-only question-input" required>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-gender-female mr-4" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M8 1a4 4 0 1 0 0 8 4 4 0 0 0 0-8M3 5a5 5 0 1 1 5.5 4.975V12h2a.5.5 0 0 1 0 1h-2v2.5a.5.5 0 0 1-1 0V13h-2a.5.5 0 0 1 0-1h2V9.975A5 5 0 0 1 3 5"/>
                                </svg>
                                <span class="text-lg font-medium">Perempuan</span>
                            </label>
                        </div>
                        <div class="text-center mt-6">
                            <button type="button" id="next-from-gender" class="bg-[#FF0000] hover:bg-[#CC0000] text-white w-12 h-12 rounded-full flex items-center justify-center transition-all ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Question 2: Job Status -->
                <div class="wizard-step-content hidden" data-step="2">
                    <div class="question-container">
                        <div class="relative">
                            <select id="job_status" name="job_status" class="w-full py-3 px-4 rounded-lg border-2 border-gray-300 focus:border-ye-accent focus:ring focus:ring-ye-accent focus:ring-opacity-50 bg-transparent text-current question-input appearance-none" required>
                                <option value="" disabled selected class="text-gray-500">Pilih status pekerjaan</option>
                                <option value="Mahasiswa" class="text-current">Mahasiswa</option>
                                <option value="Karyawan" class="text-current">Karyawan</option>
                                <option value="Freelancer" class="text-current">Freelancer</option>
                                <option value="Wirausaha" class="text-current">Wirausaha</option>
                                <option value="Belum Bekerja" class="text-current">Belum Bekerja</option>
                                <option value="Lainnya" class="text-current">Lainnya</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <button type="button" id="next-from-job" class="bg-[#FF0000] hover:bg-[#CC0000] text-white w-12 h-12 rounded-full flex items-center justify-center transition-all ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Question 3: Age -->
                <div class="wizard-step-content hidden" data-step="3">
                    <div class="question-container">
                        <div class="flex items-center justify-center">
                            <div class="relative w-40">
                                <input type="number" id="age" name="age" min="13" max="100" placeholder="Usia" class="w-full text-center text-xl font-medium py-4 border-b-2 border-gray-300 focus:border-ye-accent focus:ring-0 focus:outline-none bg-transparent question-input pr-14" required>
                                <span class="absolute right-0 top-1/2 transform -translate-y-1/2 text-sm opacity-70 pr-2">tahun</span>
                            </div>
                        </div>
                        <div class="text-center mt-6">
                            <button type="button" id="next-from-age" class="bg-[#FF0000] hover:bg-[#CC0000] text-white w-12 h-12 rounded-full flex items-center justify-center transition-all ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Question 4: Anger Reason -->
                <div class="wizard-step-content hidden" data-step="4">
                    <div class="question-container">
                        <textarea id="anger_reason" name="anger_reason" rows="4" class="w-full py-3 px-4 rounded-lg border-2 border-gray-300 focus:border-ye-accent focus:ring focus:ring-ye-accent focus:ring-opacity-50 bg-transparent question-input" required placeholder="Apa yang membuat Anda marah?"></textarea>
                        <div class="text-center mt-6">
                            <button type="button" id="next-from-reason" class="bg-[#FF0000] hover:bg-[#CC0000] text-white w-12 h-12 rounded-full flex items-center justify-center transition-all ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Question 5: Anger Level -->
                <div class="wizard-step-content hidden" data-step="5">
                    <div class="question-container">
                        <div class="flex flex-col items-center">
                            <div id="anger_level_display" class="text-7xl font-bold mb-8">5</div>
                            <div class="w-full">
                                <div class="flex justify-between mb-2">
                                    <span>Sedikit kesal</span>
                                    <span>Sangat marah</span>
                                </div>
                                <input type="range" id="anger_level" name="anger_level" min="1" max="10" value="5" class="w-full h-2 rounded-lg appearance-none cursor-pointer slider-thumb question-input" required>
                                <div class="flex justify-between mt-1">
                                    <span>1</span>
                                    <span>10</span>
                                </div>
                            </div>
                            <button type="submit" id="submit_button" class="bg-[#FF0000] hover:bg-[#CC0000] text-white w-12 h-12 rounded-full flex items-center justify-center mt-8 transition-all ml-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Question container animation */
    .question-container {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Gender option styling */
    .gender-option.selected {
        border-color: #FF0000;
        background-color: rgba(255, 0, 0, 0.1);
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .gender-option.selected::after {
        content: '✓';
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #FF0000;
        color: white;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
    
    .gender-option {
        position: relative;
    }

    /* Custom slider styling */
    .slider-thumb {
        -webkit-appearance: none;
        height: 8px;
        background: #ddd;
        border-radius: 4px;
        outline: none;
    }
    
    .slider-thumb::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #FF0000;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #FF0000;
    }
    
    .slider-thumb::-moz-range-thumb {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #FF0000;
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #FF0000;
    }
    
    /* Fix dropdown text color */
    select option {
        color: var(--text-primary);
        background-color: var(--bg-primary);
    }
    
    /* Remove outline from number input */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; 
        margin: 0; 
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const form = document.getElementById('wizardForm');
        const steps = document.querySelectorAll('.wizard-step-content');
        const genderOptions = document.querySelectorAll('.gender-option');
        const jobStatusSelect = document.getElementById('job_status');
        const ageInput = document.getElementById('age');
        const angerReasonInput = document.getElementById('anger_reason');
        const nextFromGenderBtn = document.getElementById('next-from-gender');
        const nextFromJobBtn = document.getElementById('next-from-job');
        const nextFromAgeBtn = document.getElementById('next-from-age');
        const nextFromReasonBtn = document.getElementById('next-from-reason');
        const angerLevelSlider = document.getElementById('anger_level');
        const angerLevelDisplay = document.getElementById('anger_level_display');
        const submitButton = document.getElementById('submit_button');
        
        let currentStep = 1;
        let lastFocusedInput = null;
        
        // Initialize
        updateStep(currentStep);
        
        // Handle gender selection
        genderOptions.forEach(option => {
            option.addEventListener('click', () => {
                // Clear all selections
                genderOptions.forEach(opt => opt.classList.remove('selected'));
                
                // Select the clicked option
                option.classList.add('selected');
                
                // Check the radio button
                const radio = option.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });
        
        // Handle next from gender
        nextFromGenderBtn.addEventListener('click', () => {
            const gender = document.querySelector('input[name="gender"]:checked');
            if (gender) {
                currentStep++;
                updateStep(currentStep);
            } else {
                alert('Silakan pilih jenis kelamin Anda.');
            }
        });
        
        // Handle next from job status
        nextFromJobBtn.addEventListener('click', () => {
            if (jobStatusSelect.value) {
                currentStep++;
                updateStep(currentStep);
            } else {
                alert('Silakan pilih status pekerjaan Anda.');
            }
        });
        
        // Handle next from age
        nextFromAgeBtn.addEventListener('click', () => {
            const age = ageInput.value;
            if (age && age >= 13 && age <= 100) {
                currentStep++;
                updateStep(currentStep);
            } else {
                alert('Silakan masukkan usia Anda (13-100 tahun).');
            }
        });
        
        // Handle next from anger reason
        nextFromReasonBtn.addEventListener('click', () => {
            const angerReason = angerReasonInput.value.trim();
            if (angerReason) {
                currentStep++;
                updateStep(currentStep);
            } else {
                alert('Silakan ceritakan apa yang membuat Anda marah.');
            }
        });
        
        // Update anger level display immediately
        angerLevelSlider.addEventListener('input', () => {
            angerLevelDisplay.textContent = angerLevelSlider.value;
        });
        
        // Ensure form submission works
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (validateForm()) {
                form.submit();
            }
        });
        
        function validateForm() {
            const gender = document.querySelector('input[name="gender"]:checked');
            const jobStatus = jobStatusSelect.value;
            const age = ageInput.value;
            const angerReason = angerReasonInput.value.trim();
            const angerLevel = angerLevelSlider.value;
            
            if (!gender) {
                alert('Silakan pilih jenis kelamin Anda.');
                currentStep = 1;
                updateStep(currentStep);
                return false;
            }
            
            if (!jobStatus) {
                alert('Silakan pilih status pekerjaan Anda.');
                currentStep = 2;
                updateStep(currentStep);
                return false;
            }
            
            if (!age || age < 13 || age > 100) {
                alert('Silakan masukkan usia Anda (13-100 tahun).');
                currentStep = 3;
                updateStep(currentStep);
                return false;
            }
            
            if (!angerReason) {
                alert('Silakan ceritakan apa yang membuat Anda marah.');
                currentStep = 4;
                updateStep(currentStep);
                return false;
            }
            
            return true;
        }
        
        // Update the UI based on the current step
        function updateStep(step) {
            // Hide all steps
            steps.forEach(stepEl => {
                stepEl.classList.add('hidden');
            });
            
            // Show current step
            const currentStepEl = document.querySelector(`.wizard-step-content[data-step="${step}"]`);
            currentStepEl.classList.remove('hidden');
            
            // Auto-focus the input in the current step
            const input = currentStepEl.querySelector('.question-input');
            if (input && input !== lastFocusedInput) {
                setTimeout(() => {
                    input.focus();
                    lastFocusedInput = input;
                }, 400);
            }
        }
    });
</script>
@endpush 