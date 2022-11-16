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
    let array = [];

    const generate = () => {
        divImage.innerHTML = "";

        for(let i = 0; i < array.length; i++){
            let input = document.createElement('input');
            input.type = "checkbox";
            input.checked = true;
            input.name = "image[]";
            input.value = array[i].id;
            input.style.visibility = "hidden";
            input.style.position = "absolute";

            divImage.appendChild(input);

            let div = document.createElement('div');
            div.style.position = "relative";
            div.classList.add('border', 'border-info', 'p-1', 'm-2');

            divImage.appendChild(div);

            let imageUi = document.createElement('img');
            imageUi.src = array[i].src;
            imageUi.style.height = '200px';

            div.appendChild(imageUi);

            let a = document.createElement('a');
            a.style.cursor = "pointer";

            a.classList.add('trash', 'custom-btn');

            div.appendChild(a);

            let img = document.createElement('img');
            img.src = "{{ asset('assets/trash.svg') }}"
             a.appendChild(img);

             a.addEventListener('click', () => {
                array.splice(i, 1);
                generate();
             })
        }
    }

    Array.from(images).forEach(image =>{
        image.addEventListener('click', () => {

            array.push({
                id: image.id,
                src: image.src
            });

            generate();

            // let input = document.createElement('input');
            // input.type = "checkbox";
            // input.checked = true;
            // input.name = "image[]";
            // input.value = image.id;
            // input.style.visibility = "hidden";
            // input.style.position = "absolute";

            // divImage.appendChild(input);

            // let imageUi = document.createElement('img');
            // imageUi.src = image.src;
            // imageUi.style.height = '200px';
            // imageUi.classList.add('border', 'border-info', 'p-1', 'm-2');

            // divImage.appendChild(imageUi);
        })
    })
</script>

