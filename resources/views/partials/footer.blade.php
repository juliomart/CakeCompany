<div>
    <div class="footer">
        <div class="container">
            <div class="navbar-header">


            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">

                </ul>
            </div>
        </div>
    </div>
</div>


<div>
    {{--<!-- Scripts -->--}}
	
	<script src="{{ asset("jquery/jquery.js") }}" ></script>
    <script src="{{ asset("jquery/jquery-ui.js") }}" ></script>
    <script src="{{ asset("jquery/jquery-3.2.1.slim.min.js") }}" ></script>
    <script src="{{ asset("less/less.min.js") }}" ></script>
    <script src="{{ asset("js/bootstrap.min.js") }}" ></script>
    <script src="{{ asset("js/bootstrap-datetimepicker.min.js") }}" ></script>
    <script src="{{ asset("js/moment.js") }}" ></script>
    <script src="{{ asset("js/collapse.js") }}" ></script>
    <script src="{{ asset("js/transition.js") }}" ></script>

    {{--sidebar--}}
    <script>
        $(document).ready(function () {
            var trigger = $('.hamburger'),
                overlay = $('.overlay'),
                isClosed = false;

            trigger.click(function () {
                hamburger_cross();
            });

            function hamburger_cross() {

                if (isClosed == true) {
                    overlay.hide();
                    trigger.removeClass('is-open');
                    trigger.addClass('is-closed');
                    isClosed = false;
                } else {
                    overlay.show();
                    trigger.removeClass('is-closed');
                    trigger.addClass('is-open');
                    isClosed = true;
                }
            }

            $('[data-toggle="offcanvas"]').click(function () {
                $('#wrapper').toggleClass('toggled');
            });
        });
    </script>

    <script src="{{ asset('js/app.js') }}"></script>

    {{--modal--}}
    <script type="text/javascript">

        function openModal($caller){
            var id=$caller.data('id');
            var title =$caller.data('title');
            $('#myModal').modal();
        }
    </script>
    <script type="text/javascript">

        function openModal(){
//            $("#myModal modal-footer a").attr('href', '/ingredient/'+$caller.data-('ingredient')+'/delete');
//            $("#myModal").modal();

            $('#myModal').on('show.bs.modal', function (event) {
                var id=$(this).data('id');
                $('#myModal').attr('href');
            });

            $("#myModal").modal();
        }

    </script>

    {{--add line--}}
    <script type="text/javascript">
        //$("SELECTOR") to SELECT an HTML element or HTML elementS.
        //SELECTOR = CSS class (#for ID, . for class, nothing for tag, ....)
        //To move in the tree of elements = .parent() => you get one lvl higher.
        //                                  .parents("SELECTOR") => you select the first parent with the SELECTOR.
        //.data("DATA_NAME") recover a string from the HTML element saved under data-DATA_NAME="STRING"
        //$(this) in a function = caller.
        //        in a loop = current item.0
        $(".add_line").click(function(){
        var $source = $('.'+$(this).data('target')).last();
        var $new_ingredient = $source.clone();
        $new_ingredient.children("input").val("");
        $new_ingredient.children("div").first().addClass("col-md-offset-3");
        $new_ingredient.children("label").remove();
        $($source).after($new_ingredient.clone());
        });
    </script>

    {{--remove line--}}
    <script type="text/javascript">
        $(".remove_line").click(function () {
        var $source = $('.'+$(this).data('target'));
        var $new_ingredient = $source.remove();
        $new_ingredient.parent("input");
        $new_ingredient.parent("div");
        $($source).after($new_ingredient.remove());
        })
    </script>


</div>
