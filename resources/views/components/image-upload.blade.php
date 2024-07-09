@vite(['resources/js/imageUpload.js'])

<div id="imgUploadContainer"
    class="w-full">
    <input type="file"
        name="images[]"
        id="fileInput"
        hidden
        multiple accept="image/jpeg,image/png">
    <div id="imgPreview"
        class="flex gap-5 max-w-full overflow-x-auto">
    </div>
</div>
{{-- <script src="{{ asset('js/image-upload.js') }}"></script> --}}
