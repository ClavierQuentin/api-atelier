<div class="modal fade" id="ModalImage" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Médiathèque</h5>
                <button type="button" class=" btn close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap">

                    {{-- Parcours du tableau d'urls --}}
                    @foreach ($images as $image)


                        <div class="border border-info p-1 m-2 " style="position: relative;">

                            {{-- Image --}}
                            <img height="200px" src="{{ asset('storage/'.$image->url) }}" id="{{ $image->id }}" alt="Image d'illustration" title="Image actuelle" data-dismiss="modal" class="images">

                        </div>

                    @endforeach

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
              </div>
        </div>
    </div>
</div>

<script>
    let divImage = document.getElementById('containerImage');
    let images = document.getElementsByClassName('images');

    Array.from(images).forEach(image =>{
        image.addEventListener('click', () => {
            divImage.innerHTML = "";

            let input = document.createElement('input');
            input.type = "hidden";
            input.name = "image";
            input.value = image.id;

            divImage.appendChild(input);

            let imageUi = document.createElement('img');
            imageUi.src = image.src;
            imageUi.style.height = '200px';
            imageUi.classList.add('border', 'border-info', 'p-1', 'm-2');

            divImage.appendChild(imageUi);
        })
    })
</script>

