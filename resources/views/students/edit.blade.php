<!-- In the edit view, update the parent email section to show it's optional -->
<div class="col-md-6">
    <div class="mb-3">
        <label for="parent_email" class="form-label">Parent Email (Optional)</label>
        <input type="email" class="form-control" id="parent_email" name="parent_email" value="{{ old('parent_email', $student->parent_email) }}">
        <small class="text-muted">Optional field</small>
    </div>
</div>