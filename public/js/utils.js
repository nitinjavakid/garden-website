function confirmDelete(event)
{
    return confirm("Do you really want to delete " + $(event).data("name") + "?")
}
