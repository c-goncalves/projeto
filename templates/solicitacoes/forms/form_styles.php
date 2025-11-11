<?php
function imprimir_styles() { ?>
<style>
  #stepsNav .step.active {
      background-color: #006633;
      color: white;
      font-weight: 600;
      box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }
  #stepsNav .step:hover:not(.active) {
      background-color: #78BE20;
      color: white;
  }
  .select-chip {
      display: inline-block;
      padding: 0.25rem 0.75rem;
      font-size: 0.875rem;
      font-weight: 500;
      cursor: pointer;
      background-color: #e5e7eb;
      color: #4b5563;
      border: 1px solid #d1d5db;
      transition: all 0.2s ease-in-out;
  }
  .select-chip:hover { background-color: #d1d5db; color: #1f2937; }
  input[type="checkbox"]:checked + .select-chip {
      background-color: #006633;
      color: white;
      border-color: #004d26;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
  }
</style>
<?php } ?>
