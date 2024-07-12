<x-layoutClient title="Minha Conta" :tokenCompany="$tokenCompany">

    <div class="profile-name" style="background-color: #3a497684;">
        <h3 style="color: white;">Perfil de {{ $client->name }}</h3>
    </div>

    <section class="section-myAccount">
        <div class="main-myAccount">
            <div class="card-profile">
                <div class="image-profile">
                    <img src="{{ $client->image }}" alt="Perfil" width="100px" id="profileImage">
                    <span class="icon-image-profile">
                        <i class="fa-solid fa-gear" style="color: white;"></i>
                    </span>
                </div>

                <!-- Modal de Foto de Perfil -->
                <div id="imageModal" class="modal">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content modal-myaccount-editPhoto" style="max-width: 450px !important;">
                            <div class="header-modal-EditImage" style="background-color: #3a4976;">
                                <button class="close-editImage">&times;</button>
                                <p class="title-editImageModal" style="color: white;">FOTO DO PERFIL</p>
                            </div>
                            <div class="body-editImageModal">
                                <img src="" alt="Perfil" id="modalImage" width="150px" height="150px">
                                <span class="iconMyCorte-editImagelModal">
                                    <img src="{{ asset('images/apenasLogo.svg') }}" alt="Icon MYCORTE" width="30px" height="30px">
                                </span>
                            </div>

                            <p style="font-style: italic; font-size: 12px; color: gray; margin: 2px 2px;">Caso nenhuma foto seja selecionada, escolheremos um dos nossos icons que combina mais com você para substituir</p>

                            <div class="editImageModal-options">
                                <form id="uploadForm" enctype="multipart/form-data" action="{{ route('uploadPhotoClient', ['tokenCompany' => $tokenCompany]) }}" method="POST">
                                    @csrf
                                    <input type="file" id="uploadPhoto" name="photo" style="display: none;">
                                    <div class="editImageModal-optionsUpload">
                                        <button type="button" id="cancelUpload" class="btn btn-danger" style="display: none;">Cancelar Foto</button>
                                        <button type="submit" id="updatePhoto" class="btn btn-primary" style="display: none;">Atualizar Foto</button>
                                    </div>
                                </form>
                                <button id="deletePhoto" class="btn btn-danger">Remover foto</button>
                                <label for="uploadPhoto" id="selectPhoto" class="btn btn-primary">Selecionar Foto</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info-card-profile">
                    <h4></h4>
                    <ul class="info-profile-list">
                        <li>
                            <div class="image-container">
                                <img src="{{ asset('images/icons/Icongmail.png') }}" alt="Icon Gmail">
                            </div>
                        </li>
                        <li>
                            <div class="image-container">
                                <img src="{{ asset('images/icons/whatsappIcon.png') }}" alt="Whatsapp Icon">
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="biografia">
                <h5>Suas Informações</h5>

                <ul class="list-biografia">
                    <li id="icon-Edit-biogragia">
                        <p class="icon-Edit-biogragia">
                            <i class="fa-solid fa-pencil edit-icon"></i>
                        </p>
                    </li>
                    <li>
                        <p id="bioNome"><strong>Nome:</strong> {{ $client->name }}</p>
                    </li>
                    <li>
                        <p id="bioTelefone"><strong>Telefone:</strong> {{ $client->telephone }}</p>
                    </li>
                    <li>
                        <p id="bioEmail"><strong>Email:</strong> {{ $client->email }}</p>
                    </li>
                </ul>

                {{--                <h5>Serviços Favoritos</h5>--}}

                {{--                <ul class="biografia-serices-favorite">--}}
                {{--                    <li>--}}
                {{--                        <p id="service-favorite">Corte de Cabelo</p>--}}
                {{--                    </li>--}}
                {{--                    <li>--}}
                {{--                        <p id="service-favorite">Barba</p>--}}
                {{--                    </li>--}}
                {{--                    <li>--}}
                {{--                        <p id="service-favorite">Alisamento</p>--}}
                {{--                    </li>--}}
                {{--                    <li>--}}
                {{--                        <p id="service-favorite">Luzes</p>--}}
                {{--                    </li>--}}
                {{--                    <li>--}}
                {{--                        <p id="service-favorite">Sobrancelha</p>--}}
                {{--                    </li>--}}
                {{--                    <li>--}}
                {{--                        <p id="service-favorite">Mid Fade</p>--}}
                {{--                    </li>--}}
                {{--                </ul>--}}
            </div>
        </div>
    </section>

    {{--    <section class="conquistas" style="background-color: #6d82c4;">--}}
    {{--        <ul class="list-conquistas">--}}
    {{--            <li>--}}
    {{--                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">--}}
    {{--                <h4>+2000</h4>--}}
    {{--                <p>Cortes no último mês</p>--}}
    {{--            </li>--}}

    {{--            <li>--}}
    {{--                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">--}}
    {{--                <h4>5000</h4>--}}
    {{--                <p>Cortes ao total, UAU!!!</p>--}}
    {{--            </li>--}}

    {{--            <li>--}}
    {{--                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">--}}
    {{--                <h4>+100</h4>--}}
    {{--                <p>Barbas feitas em dois meses</p>--}}
    {{--            </li>--}}

    {{--            <li>--}}
    {{--                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">--}}
    {{--                <h4>30/4</h4>--}}
    {{--                <p>Cliente semanal, Sempre alinhado!</p>--}}
    {{--            </li>--}}
    {{--        </ul>--}}
    {{--    </section>--}}

    <!-- Modal de Edição de Biografia -->
    <div id="biografiaModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-myaccount-editBiografia" style="max-width: 450px !important;">
                <div class="header-modal-Biografia" style="background-color: #3a4976;">
                    <button class="close-editBiografia">&times;</button>
                    <p class="title-editBiografiaModal" style="color: white;">EDITAR SUAS INFORMAÇÕES</p>
                </div>
                <div class="body-editBiografiaModal">
                    <form id="editBiografiaForm" action="{{ route('client.myaccount.update', ['tokenCompany' => $tokenCompany]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="tokenCompany" value="{{ $tokenCompany }}">
                        <div class="form-group">
                            <label for="editNome">Nome:</label>
                            <input type="text" id="editNome" class="form-control" name="name" value="{{ $client->name }}" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="editTelefone">Telefone:</label>
                            <input type="text" id="editTelefone" class="form-control" name="telephone" value="{{ $client->telephone }}" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="email" id="editEmail" class="form-control" name="email" value="{{ $client->email }}" disabled autocomplete="new-password">
                        </div>
                        <p style="margin-bottom: 0px; font-style: italic; font-size: 11px; color: gray;">
                            <strong>OBS:</strong> após alterar os dados para confirmar alterar será necessário que confirme seu login por segurança.
                        </p>
                        <div class="buttons-modalBiografia">
                            <button type="button" class="btn btn-primary" id="cancelEditBio">Cancelar Edição</button>
                            <button type="submit" class="btn btn-primary" id="saveEditBio">Salvar Edição</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('imageModal');
            const profileImg = document.getElementById('profileImage');
            const modalImg = document.getElementById('modalImage');
            const icon = document.querySelector('.icon-image-profile');
            const closeBtn = document.querySelector('.close-editImage');
            const updatePhotoBtn = document.getElementById('updatePhoto');
            const cancelUploadBtn = document.getElementById('cancelUpload');
            const deletePhotoBtn = document.getElementById('deletePhoto');
            const uploadPhotoInput = document.getElementById('uploadPhoto');
            const selectPhotoBtn = document.getElementById('selectPhoto');
            const services = document.querySelectorAll('.biografia-serices-favorite li p');
            const editBioIcon = document.querySelector('.edit-icon');
            const bioNome = document.getElementById('bioNome');
            const bioTelefone = document.getElementById('bioTelefone');
            const bioEmail = document.getElementById('bioEmail');
            const biografiaModal = document.getElementById('biografiaModal');
            const closeEditBioBtn = document.querySelector('.close-editBiografia');
            const saveEditBioBtn = document.getElementById('saveEditBio');
            const cancelEditBioBtn = document.getElementById('cancelEditBio');
            const editNome = document.getElementById('editNome');
            const editTelefone = document.getElementById('editTelefone');
            const editEmail = document.getElementById('editEmail');

            profileImg.addEventListener('click', function() {
                modal.style.display = 'block';
                modalImg.src = this.src;
            });

            icon.addEventListener('click', function() {
                modal.style.display = 'block';
                modalImg.src = profileImg.src;
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            editBioIcon.addEventListener('click', function() {
                biografiaModal.style.display = 'block';
            });

            closeEditBioBtn.addEventListener('click', function() {
                biografiaModal.style.display = 'none';
            });

            cancelEditBioBtn.addEventListener('click', function() {
                biografiaModal.style.display = 'none';
            });

            uploadPhotoInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalImg.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                    updatePhotoBtn.style.display = 'inline-block';
                    cancelUploadBtn.style.display = 'inline-block';
                }
            });

            selectPhotoBtn.addEventListener('click', function() {
                uploadPhotoInput.click();
            });

            cancelUploadBtn.addEventListener('click', function() {
                uploadPhotoInput.value = '';
                modalImg.src = profileImg.src;
                updatePhotoBtn.style.display = 'none';
                cancelUploadBtn.style.display = 'none';
            });

            deletePhotoBtn.addEventListener('click', function() {
                // Lógica para remover a foto do perfil
            });

            document.getElementById('editBiografiaForm').addEventListener('submit', function(event) {
                // Remova a prevenção do evento, para permitir o envio do formulário
            });

            function checkForChanges() {
                const currentNome = bioNome.textContent.split(': ')[1];
                const currentTelefone = bioTelefone.textContent.split(': ')[1];
                const currentEmail = bioEmail.textContent.split(': ')[1];

                const isChanged = currentNome !== editNome.value || currentTelefone !== editTelefone.value || currentEmail !== editEmail.value;

                if (isChanged) {
                    saveEditBioBtn.classList.add('btn-save-enabled');
                    saveEditBioBtn.classList.remove('btn-save-disabled');
                    saveEditBioBtn.disabled = false;
                } else {
                    saveEditBioBtn.classList.add('btn-save-disabled');
                    saveEditBioBtn.classList.remove('btn-save-enabled');
                    saveEditBioBtn.disabled = true;
                }
            }

            editNome.addEventListener('input', checkForChanges);
            editTelefone.addEventListener('input', checkForChanges);
            editEmail.addEventListener('input', checkForChanges);
        });
    </script>

</x-layoutClient>
