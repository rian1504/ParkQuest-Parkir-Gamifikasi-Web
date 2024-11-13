<x-filament::page>
    <center>
        <video controls>
            <source src="{{ asset('storage/' . $this->record->survey_video) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </center>
</x-filament::page>
