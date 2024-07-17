<?= $this->extend('layout/admin') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Formulir Umpan Balik</div>

                <div class="card-body">
                    <form id="feedbackForm">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Feedback</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        // Submit form feedback menggunakan AJAX
        $('#feedbackForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '<?= base_url('main/feedback/submit') ?>', // Ganti dengan URL endpoint untuk menyimpan feedback
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Feedback berhasil dikirim. Terima kasih atas partisipasinya! -TE37');
                        $('#feedbackForm')[0].reset(); // Reset form setelah pengiriman berhasil
                    } else {
                        alert('Gagal mengirim feedback. Silakan coba lagi.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>