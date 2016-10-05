$(function() {
    $('form').sortable({
        axis: "y",
        containment: "parent",
        cursor: "move",
//        delay: 150,
//        distance: 32,
        handle: "legend",
        opacity: 0.5,
        tolerance: "pointer",
//        placeholder: "sortable-placeholder"
    });
});