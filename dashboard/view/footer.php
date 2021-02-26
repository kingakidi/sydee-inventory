
            <!-- Footer -->
            <!-- <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span> &copy; jumga.com 2021</span>
                    </div>
                </div>
            </footer> -->
            <!-- End of Footer -->

            </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <div class="popup-page" id="popup-page">
        
        <div class="popup-content" id="popup-content">
            

            <div class="show-popup-content" id="show-popup-content">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum blanditiis molestiae autem minus, soluta suscipit quo nesciunt qui nisi dolore cum velit quos debitis repellat aut consequatur, non id quod.
                Neque suscipit illo a obcaecati consequuntur, voluptatum maiores repellat corrupti dolore minus cupiditate perferendis distinctio quaerat. Neque facilis eligendi ipsam sequi, atque minima illum dolore molestiae consequuntur aspernatur expedita pariatur!
                A iste neque delectus laborum sed! Doloremque deserunt placeat iure inventore autem quidem omnis soluta cupiditate quisquam officia, nemo perferendis sapiente perspiciatis facilis fuga ratione. Ipsa tempora voluptates tenetur temporibus!
                Quaerat, itaque unde ad possimus saepe recusandae repudiandae accusantium nam corporis, vero voluptatum nulla atque, sed autem optio magni eos corrupti aliquam eligendi animi. Iusto consectetur vel deleniti distinctio quae?
                Vitae tempora deleniti nisi pariatur consequatur illum maxime exercitationem culpa accusamus repudiandae, earum labore ducimus officiis doloribus dolore ut enim magni odit eligendi inventore! Voluptate deleniti quo maiores magni modi. Lorem ipsum dolor sit amet consectetur adipisicing elit. Error odit praesentium velit quia soluta ipsum ex corporis corrupti veritatis, quaerat distinctio atque, sequi, aspernatur nobis natus aliquam quisquam. Sint, vero! Lorem ipsum dolor sit amet consectetur adipisicing elit. Perferendis consequatur ducimus voluptates recusandae provident odio necessitatibus quis, adipisci animi! Repellat aut praesentium repudiandae dolores nesciunt quaerat asperiores aliquid a deserunt? Lorem, ipsum dolor sit amet consectetur adipisicing elit. Facere culpa harum dicta beatae saepe. Exercitationem nisi, eaque molestiae odio adipisci aspernatur quaerat quas maxime corrupti ab error, et veritatis necessitatibus.
                Voluptatum laboriosam voluptas sit omnis, qui ut. Debitis sunt unde impedit natus vitae! Porro tenetur officia mollitia quia quod recusandae aliquid aspernatur reprehenderit quos voluptate? Nulla quaerat est harum incidunt!
                Maxime quae deleniti inventore similique. Obcaecati quia consectetur veniam, hic quidem atque assumenda modi quod laboriosam eveniet maxime eum pariatur commodi cumque dolor explicabo! Cum, voluptas doloremque. Inventore, saepe explicabo!
            </div>
            <div class="popup-close form-group" >
                <button id="popup-close" class="btn btn-danger">Close</button>
            </div>
              
        </div>
    </div>



    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- <script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->
    
    <!-- STATE AND LGA -->
    <script src="js/lga.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    <script src="./vendor/datatable/datatables.js"></script>
    <script src="../js/sydeestack.js"></script>
    <?php 
    
        if (isset($_GET['p'])) {
            $p = $_GET['p'];
        
            echo "<script src='js/$p.js'></script>";
        }
    ?>
        <!-- <div class="popup-page" id="popup-page">
           <div class="popup-content" id="popup-content">
               I AM CONTENT 
           </div>
        </div> -->
</body>

</html>