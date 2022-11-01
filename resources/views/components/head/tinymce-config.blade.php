<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: 'textarea#editeur', 
    plugins: 'powerpaste advcode table lists checklist',
    toolbar: 'undo redo | blocks| bold italic | bullist numlist checklist | alignleft | aligncenter | alignright | alignjustify',
    toolbar_mode: 'floating'
  });
</script>
