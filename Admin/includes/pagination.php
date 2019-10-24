<?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
<?php 

if(isset($_GET['limit'])){
    $num_results_on_page = $_GET['limit'];
} else {
    $num_results_on_page = 5; //Kundgräns på hur många kunder som ska visas i vyn.
}

?>
<div class="d-flex justify-content-center" style="margin-top:30px;">
    <nav aria-label="kundtjanster">
        <ul class="pagination">
            <?php if ($page > 1): ?>
            <li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page-1 ?>">Tillbaka</a></li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
            <li class="start"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=1">1</a></li>
            <li class="dots"><a class="page-link">. . .</a></li>
            <?php endif; ?>

            <?php if ($page-2 > 0): ?><li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page-2 ?>"><?php echo $page-2 ?></a></li><?php endif; ?>
            <?php if ($page-1 > 0): ?><li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page-1 ?>"><?php echo $page-1 ?></a></li><?php endif; ?>

            <li class="page-item active"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page ?>"><?php echo $page ?></a></li>

            <?php if ($page+1 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page+1 ?>"><?php echo $page+1 ?></a></li><?php endif; ?>
            <?php if ($page+2 < ceil($total_pages / $num_results_on_page)+1): ?><li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page+2 ?>"><?php echo $page+2 ?></a></li><?php endif; ?>

            <?php if ($page < ceil($total_pages / $num_results_on_page)-2): ?>
            <li class="dots"><a class="page-link">. . .</a></li>
            <li class="end"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo ceil($total_pages / $num_results_on_page) ?>"><?php echo ceil($total_pages / $num_results_on_page) ?></a></li>
            <?php endif; ?>

            <?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
            <li class="page-item"><a class="page-link" href="index.php?limit=<?php echo $num_results_on_page ?>&page=<?php echo $page+1 ?>">Nästa</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</div>
<?php endif; ?>
