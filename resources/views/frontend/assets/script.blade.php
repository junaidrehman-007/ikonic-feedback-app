<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="{{ asset('frontend/assets') }}/js/jquery.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/jquery.hoverIntent.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/jquery.waypoints.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/superfish.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/owl.carousel.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/bootstrap-input-spinner.js"></script>
<script src="{{ asset('frontend/assets') }}/js/jquery.elevateZoom.min.js"></script>
<script src="{{ asset('frontend/assets') }}/js/bootstrap-input-spinner.js"></script>
<script src="{{ asset('frontend/assets') }}/js/jquery.magnific-popup.min.js"></script>
<!-- Main JS File -->
<script src="{{ asset('frontend/assets') }}/js/main.js"></script>



<script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"></script>
<script>
    // Check for a success message in the session
    @if (Session::has('success_message'))
        // Display a Toastr notification
        toastr.success("{{ Session::get('success_message') }}");
    @endif
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
    $(".upvote, .downvote").click(function() {
        var feedbackId = $(this).data("feedback");
        var voteType = $(this).hasClass("upvote") ? 1 : -1;

        // Make an AJAX request to handle the vote
        $.ajax({
            url: '/vote',
            method: 'POST',
            data: {
                feedback_id: feedbackId,
                vote_type: voteType,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
               
                toastr.success('Your vote was successfully counted.');
                window.location.reload();
              
            },
            error: function(xhr) {
              
                if (xhr.status === 422) {
                    toastr.error(xhr.responseJSON.error);
                } else {
                    toastr.error('An error occurred while processing your vote.');
                }
            }
        });
    });
});


$(document).ready(function () {
    $(".comment-box").each(function () {
        var feedbackId = $(this).data("feedback");

        // Initialize SimpleMDE
        var simplemde = new SimpleMDE({
            element: $("#simplemde-editor-" + feedbackId)[0],
            spellChecker: false,
            minHeight: '40px',
            maxHeight:'50px !important',
        });

        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#ckeditor-editor-' + feedbackId), {
                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        '|', // Separator
                        'codeBlock'
                    ],
                    shouldNotGroupWhenFull: true
                },
                language: 'en',
            })
            .catch(error => {
                console.error(error);
            });

        $(this).hide();
    });

    $(".toggle-comments").click(function (e) {
        e.preventDefault();
        var feedbackId = $(this).data("feedback");
        $(".comment-box[data-feedback='" + feedbackId + "']").toggle();
    });
});
</script>

<script>
    $(document).ready(function() {
   
        // Fetch unread notifications via AJAX
        $.ajax({
            url: '{{ route('notifications.unread') }}',
            method: 'GET',
            success: function(data) {
               

                // Update the cart count with the number of unread notifications
                $('.cart-count').text(data.notifications.length);
            }
        });
   
});

</script>