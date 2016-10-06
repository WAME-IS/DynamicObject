$(function() {
    $('form').sortable({
        containment: "parent",
        cursor: "move",
//        delay: 150,
//        distance: 32,
        handle: "legend",
        items: ".group",
        opacity: 0.5,
        tolerance: "pointer"
//        placeholder: "sortable-placeholder",
    });
});