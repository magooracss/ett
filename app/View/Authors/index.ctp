<!-- File: /app/View/Author/index.ctp -->

<h1>Listado de Autores</h1>
<table>
    <tr>
        <th>Nombre</th>
        <th>Historias</th>
    </tr>


    <?php foreach ($authors as $author): ?>
    <tr>
        <td><?php echo $author['Author']['name']; ?></td>
        <td>
            --
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($author); ?>
</table>
