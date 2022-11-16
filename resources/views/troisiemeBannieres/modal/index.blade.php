<div class="modal fade" id="ModalImage2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">test</h5>
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
                            <img height="200px" src="{{ asset('storage/'.$image->url) }}" id="{{ $image->id }}" alt="Image d'illustration" title="Image actuelle" data-dismiss="modal" class="images2">

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
    let divImage2 = document.getElementById('containerImage2');
    let images2 = document.getElementsByClassName('images2');

    Array.from(images2).forEach(image =>{
        image.addEventListener('click', () => {
            divImage2.innerHTML = "";

            let input2 = document.createElement('input');
            input2.type = "hidden";
            input2.name = "image2";
            input2.value = image.id;

            divImage2.appendChild(input2);

            let imageUi2 = document.createElement('img');
            imageUi2.src = image.src;
            imageUi2.style.height = '200px';
            imageUi2.classList.add('border', 'border-info', 'p-1', 'm-2');

            divImage2.appendChild(imageUi2);
        })
    })
</script>

