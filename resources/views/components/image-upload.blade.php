{{-- <div id="imgUploadContainer"
    class="w-full h-fit">
    <input type="file"
        name="images[]"
        class="fileInput"
        id="fileInput"
        hidden
        multiple accept="image/jpeg,image/png">
    <div id="imgPreview"
        class="imgPreview flex gap-5 max-w-full overflow-x-scroll max-h-80">
    </div>
</div> --}}

<div id="imgUploadContainer"
    class="flex gap-5 max-w-full overflow-x-scroll max-h-80">
    @if ($isEdit && $postImages)
        <input type="hidden"
            id="postedImages"
            value="{{ json_encode($postImages) }}">
    @endif
    <div id="imgPreview"
        class="imgPreview flex gap-5 max-w-full overflow-x-scroll max-h-80">
    </div>
    <input type="file"
        name="images[]"
        class="fileInput"
        id="fileInput"
        hidden
        multiple
        accept="image/jpeg,image/png">
</div>
