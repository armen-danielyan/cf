jQuery(function ($) {
    $(document).ready(function () {
        $('#o-reviews').DataTable({
            'filter': false,
            'info': false,
            'bLengthChange' : true,
            "dom": '<"top">rt<"bottom"flp><"clear">'
        });
        $('#d-reviews-done').DataTable({
            'filter': false,
            'info': false,
            'bLengthChange' : true,
            "dom": '<"top">rt<"bottom"flp><"clear">'
        });
        $('#d-with-search-list').DataTable({
            'info': false,
            'bLengthChange' : true,
            "dom": '<"top">rt<"bottom"flp><"clear">'
        });

        $('#d-with-search-list_filter').appendTo('#datatable-searchbar');
        $('#d-with-search-list_filter input[type=search]').attr('placeholder', 'Search');
        $('#d-with-search-list_filter input[type=search]').appendTo('#datatable-searchbar');
        $('#d-with-search-list_filter').remove();
    })
});