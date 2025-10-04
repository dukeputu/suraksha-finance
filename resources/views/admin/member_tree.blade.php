@extends('layouts.app')
@section('title', 'Member Tree')

@section('content')





<div class="mlm-tree">
  <ul>
    <li>
      {{-- <div class="node toggle open">➖ 👑 Root</div> --}}
      {!! $treeHtml !!}
    </li>
  </ul>
</div>
@endsection


<style>
.mlm-tree {
  padding: 20px;
  font-family: 'Segoe UI', sans-serif;
  color: #444;
}

.mlm-tree ul {
  padding-left: 30px;
  border-left: 2px dashed #ccc;
  margin-left: 15px;
}

.mlm-tree li {
  list-style: none;
  margin: 10px 0;
  position: relative;
}

.mlm-tree .node {
  background: #f8f9fa;
  padding: 8px 12px;
  border-radius: 6px;
  border: 1px solid #ccc;
  display: inline-block;
  font-size: 14px;
  cursor: pointer;
  transition: 0.3s ease;
  position: relative;
}

.mlm-tree .node:hover {
  background: #e0f7fa;
  border-color: #17a2b8;
  font-weight: bold;
}

.children {
  display: block;
}

/* collapsed hidden */
.node:not(.open) + .children {
  display: none;
}
</style>



<script>
document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.node.toggle').forEach(function (node) {
    node.addEventListener('click', function () {
      node.classList.toggle('open');
      const children = node.nextElementSibling;
      if (children && children.classList.contains('children')) {
        children.style.display = node.classList.contains('open') ? 'block' : 'none';
      }

      // Toggle plus/minus icon
      node.innerHTML = node.innerHTML.replace(/^➕/, '➖');
      if (!node.classList.contains('open')) {
        node.innerHTML = node.innerHTML.replace(/^➖/, '➕');
      }
    });
  });
});
</script>



