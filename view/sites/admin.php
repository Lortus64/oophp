<?php
if (!$resultset) {
    return;
}
?>

<h3>
    <a href="create" title="Create content">
        Create
    </a>
</h3>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a href="edit?&amp;id=<?= $row->id ?>" title="Edit this content">
                Edit
            </a>
            |
            <a href="delete?&amp;id=<?= $row->id ?>" title="Edit this content">
                Del
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
