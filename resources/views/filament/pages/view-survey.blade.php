<x-filament::page>
    <center>
        <video controls width="500" height="500">
            <source src="{{ asset('storage/' . $this->record->survey_video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </center>
</x-filament::page>
