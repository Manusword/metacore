<div class="main-content">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

<style>
.orgchart ul{padding-top:20px}
.orgchart li{list-style:none;text-align:center;margin:10px;display:inline-block}
.node{
    padding:10px 14px;
    border-radius:10px;
    cursor:pointer;
    background:#fff;
    border:2px solid #0d6efd;
    min-width:130px;
    position:relative;
}
.level-1{border-color:#dc3545}
.level-2{border-color:#fd7e14}
.level-3{border-color:#ffc107}
.level-4{border-color:#198754}
.level-5{border-color:#0dcaf0}
.children{display:none;margin-top:10px}
.highlight{background:#ffe69c}
</style>

<div class="card">
<div class="card-body">

<input class="form-control mb-3 w-25" placeholder="Search..." id="search">

<div class="orgchart" id="chart">

<?php
function drawTree($tree,$info,$analytics){
    echo "<ul>";
    foreach($tree as $emp=>$kids){
        $d=$info[$emp];
        $lvl=(int)$d['level'];

        echo "<li>
        <div class='node level-$lvl' onclick=\"toggleNode(this)\" data-name='{$d['emp_name']}' data-code='$emp'>
            <strong>{$d['emp_name']}</strong><br>
            {$d['designation']}<br>
            <small>{$d['department']}</small><br>
            <span class='badge bg-dark'>Team: ".($analytics[$emp]??0)."</span>
        </div>";

        if($kids){
            echo "<div class='children'>";
            drawTree($kids,$info,$analytics);
            echo "</div>";
        }

        echo "</li>";
    }
    echo "</ul>";
}
drawTree($tree,$info,$analytics);
?>

</div>
</div>
</div>

<!-- MODAL -->
<div class="modal fade" id="chainModal">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header"><h5>Reporting Chain</h5></div>
<div class="modal-body" id="chainBody"></div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// collapse expand
function toggleNode(el){
    let child=el.parentElement.querySelector(".children");
    if(child) child.style.display = child.style.display=="block"?"none":"block";
}

// search fast
document.getElementById("search").addEventListener("keyup",function(){
 let v=this.value.toLowerCase();
 document.querySelectorAll(".node").forEach(n=>{
  n.style.display=n.dataset.name.toLowerCase().includes(v)?"block":"none";
 });
});

// reporting chain popup
document.querySelectorAll(".node").forEach(node=>{
 node.addEventListener("dblclick",function(e){
    e.stopPropagation();
    let chain=[];
    let el=this;
    while(el){
        chain.push(el.dataset.name);
        el=el.closest("ul").closest("li")?.querySelector(".node");
    }
    document.getElementById("chainBody").innerHTML=chain.join(" → ");
    new bootstrap.Modal(document.getElementById('chainModal')).show();
 });
});
</script>
</div>