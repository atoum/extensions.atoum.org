hljs.initHighlightingOnLoad();

function toggleMenu(element) {
    var target = document.getElementById(element.getAttribute("aria-controls"));

    if (!target) {
        return;
    }

    var selected = target.getAttribute("aria-selected") === "true";

    target.setAttribute("aria-selected", !selected);
    target.setAttribute("aria-hidden", selected);
}


function toggleSearch(isOnFocus)
{
    if (isOnFocus) {
        document.body.classList.add("search-focused");
    } else {
        document.body.classList.remove('search-focused');
    }

}
