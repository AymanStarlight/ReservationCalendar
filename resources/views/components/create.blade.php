<!-- Button trigger modal -->
<button type="button" class="btn btn-danger d-none" data-bs-toggle="modal" data-bs-target="#exampleModal" id="modalOpen">
    Make a New Reservation
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Make a New Reservation</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reservation.store') }}" method="POST">
            <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input required class='form-control' type="text" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea required class='form-control' type="text" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="day" class="form-label">Day</label>
                        <input required class='form-control' type="date" id="day" name="day" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y'); ?>-12-31"
                            value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="start" class="form-label">Start</label>
                        <input required class='form-control' type="time" min="08:00:00" max="18:00:00" value='09:00:00' step="1800"
                            id="start" name="start">
                    </div>
                    <div class="mb-3">
                        <label for="end" class="form-label">End</label>
                        <input required class='form-control' type="time" min="08:00:00" max="18:00:00" value='10:00:00' step="1800"
                            id="end" name="end">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Reservation</button>
                </div>
            </form>
        </div>
    </div>
</div>
