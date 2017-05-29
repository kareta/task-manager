


<form id="task-form">

    <?= $this->csrfToken() ?>

    <div class="col-md-12 form-group no-padding">
        <label for="task-username">Username</label>
        <input id="task-username" type="text" name="username" class="max-width-300 form-control input-md">
    </div>

    <div class="col-md-12 form-group no-padding">
        <label for="task-email">Email</label>
        <input id="task-email" type="email" name="email" class="max-width-300 form-control input-md">
    </div>

    <div class="form-group">
        <label for="task-content" class="col-md-12 no-padding">Content</label>
        <textarea id="task-content" name="content" class="col-md-12 form-control max-width-770"> </textarea>
    </div>

    <!-- Put a space between form control and file upload button. -->
    <p>&nbsp</p>

    <div class="form-group">
        <label for="task-image" class="file-label">Pick an image</label>
        <input id="task-image" type="file" name="image">
    </div>

    <div class="form-group text-center">
        <button id="task-submit" class="btn btn-primary" name="submit">Create task</button>
        <button id="task-preview" class="btn btn-default" name="preview">Preview</button>

    </div>
</form>