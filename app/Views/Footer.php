<!-- FOOTER -->
<footer class="footer bg-dark shadow z-5 mt-auto text-white text-end py-3 mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                &copy; <?=(date('Y') == CREATED_YEAR) ? CREATED_YEAR : CREATED_YEAR . " - " . date('Y') ; ?> <?=ORG_NAME?>
            </div>
        </div>
    </div>
</footer>