@component('mail::message')
    <h2>
        Congratulations {{$candidate->user->first_name}} {{$candidate->user->last_name}} !!! <br>
    </h2>
    Your application was accepted by {{$candidate->job_opening->company->name}}, they will be contacting you soon to
    let you know about the next step.

    Best wishes,
    Hiring app Team
@endcomponent()
