</div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Penataan Master Barang</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- SweetAlert2 Library CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script Notifikasi SweetAlert berdasarkan Parameter Status PHP -->
    <script>
    $(document).ready(function() {
        // Ambil query parameter 'status' dari URL
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data berhasil disimpan.',
                timer: 2500,
                showConfirmButton: false
            });
            // Hapus parameter URL agar saat refresh alert tidak muncul lagi
            window.history.replaceState({}, document.title, window.location.pathname);
        } else if (status === 'update_success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Diperbarui!',
                text: 'Data berhasil diperbarui.',
                timer: 2500,
                showConfirmButton: false
            });
            // Hapus parameter URL agar saat refresh alert tidak muncul lagi
            window.history.replaceState({}, document.title, window.location.pathname);
        } else if (status === 'delete_success') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Dihapus!',
                text: 'Data berhasil dihapus.',
                timer: 2500,
                showConfirmButton: false
            });
            // Hapus parameter URL agar saat refresh alert tidak muncul lagi
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
    </script>

</body>

</html>