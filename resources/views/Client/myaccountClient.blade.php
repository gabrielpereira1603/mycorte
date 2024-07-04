<x-layoutClient title="Minha Conta" :tokenCompany="$tokenCompany">

    <div class="profile-name" style="background-color: #3a497684;">
        <h3 style="color: white;">Perfil de {{ $client->name }}</h3>
    </div>

    <section class="section-myAccount">
        <div class="main-myAccount">
            <div class="card-profile">
                <div class="image-profile">
                    <img src="{{ asset('storage/app/public/' . $client->image) }}" alt="Perfil" width="100px" id="profileImage">
                    <p>{{ asset('storage/app/public/' . Auth::guard('client')->user()->image) }}</p>
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

                            <p style="font-style: italic; font-size: 12px; color: gray; margin: 2px 2px;">Caso nenhuma foto seja selecionada, escolheremos um dos nossos icons que combina mais com voçê para substituir</p>

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

                <h5>Serviços Favoritos</h5>

                <ul class="biografia-serices-favorite">
                    <li>
                        <p id="service-favorite">Corte de Cabelo</p>
                    </li>
                    <li>
                        <p id="service-favorite">Barba</p>
                    </li>
                    <li>
                        <p id="service-favorite">Alisamento</p>
                    </li>
                    <li>
                        <p id="service-favorite">Luzes</p>
                    </li>
                    <li>
                        <p id="service-favorite">Sombrancelha</p>
                    </li>
                    <li>
                        <p id="service-favorite">Mid Fade</p>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <section class="conquistas" style="background-color: #6d82c4;">
        <ul class="list-conquistas">
            <li>
                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">
                <h4>+2000</h4>
                <p>Cortes no ultimo mês</p>
            </li>

            <li>
                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">
                <h4>5000</h4>
                <p>Cortes ao total, UAU!!!</p>
            </li>

            <li>
                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">
                <h4>+100</h4>
                <p>Barbas feitas em dois meses</p>
            </li>

            <li>
                <img src="{{ asset('images/icons/conquistasIcon.png') }}" alt="">
                <h4>30/4</h4>
                <p>Cliente semanal, Sempre alinhado!</p>
            </li>
        </ul>
    </section>

    <!-- Modal de Edição de Biografia -->
    <div id="biografiaModal" class="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-myaccount-editBiografia" style="max-width: 450px !important;">
                <div class="header-modal-Biografia" style="background-color: #3a4976;">
                    <button class="close-editBiografia">&times;</button>
                    <p class="title-editBiografiaModal" style="color: white;">EDITAR SUAS INFORMAÇÕES</p>
                </div>
                <div class="body-editBiografiaModal">
                    <form id="editBiografiaForm">
                        <div class="form-group">
                            <label for="editNome">Nome:</label>
                            <input type="text" id="editNome" class="form-control" value="" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="editTelefone">Telefone:</label>
                            <input type="text" id="editTelefone" class="form-control" value="" autocomplete="new-password">
                        </div>

                        <div class="form-group">
                            <label for="editEmail">Email:</label>
                            <input type="email" id="editEmail" class="form-control" value="" disabled autocomplete="new-password">
                        </div>
                        <p style="margin-bottom: 0px; font-style: italic; font-size: 11px; color: gray;">
                            <strong>OBS:</strong> após alterar os dados para confirmar alterar será necessario que confirme seu login por segurança.
                        </p>
                        <div class="buttons-modalBiografia">
                            <button class="btn btn-primary" id="cancelEditBio">Cancelar Edição</button>
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
            const services = document.querySelectorAll('.biografia-serices-favorite p');
            const FormUpload = document.getElementById('uploadForm');

            const biografiaModal = document.getElementById('biografiaModal');
            const editIcon = document.getElementById('icon-Edit-biogragia');
            const closeBiografiaBtn = document.querySelector('.close-editBiografia');

            const bioNome = document.getElementById('bioNome');
            const bioTelefone = document.getElementById('bioTelefone');
            const bioEmail = document.getElementById('bioEmail');

            const editNome = document.getElementById('editNome');
            const editTelefone = document.getElementById('editTelefone');
            const editEmail = document.getElementById('editEmail');

            let originalPhotoSrc = profileImg.src;

            // Função para gerar cor aleatória em formato hexadecimal
            function getRandomColor() {
                return '#' + Math.floor(Math.random() * 16777215).toString(16);
            }

            // Função para verificar se a cor é escura
            function isDarkColor(color) {
                const hexToRgb = (hex) => {
                    const bigint = parseInt(hex.substring(1), 16);
                    const r = (bigint >> 16) & 255;
                    const g = (bigint >> 8) & 255;
                    const b = bigint & 255;
                    return [r, g, b];
                };

                const [r, g, b] = hexToRgb(color);
                const brightness = (r * 299 + g * 587 + b * 114) / 1000;
                return brightness < 128;
            }

            services.forEach(function(service) {
                const randomColor = getRandomColor();
                service.style.backgroundColor = randomColor;
                if (isDarkColor(randomColor)) {
                    service.style.color = 'white';
                }
            });

            icon.addEventListener('click', function() {
                modal.style.display = 'block';
                modalImg.src = profileImg.src;
            });

            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            });

            uploadPhotoInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        modalImg.src = e.target.result;
                        profileImg.src = e.target.result;
                        selectPhotoBtn.style.display = 'none';
                        updatePhotoBtn.style.display = 'inline-block';
                        cancelUploadBtn.style.display = 'inline-block';
                        deletePhotoBtn.style.display = 'none';
                        FormUpload.style.width = '100%';
                    };
                    reader.readAsDataURL(file);
                }
            });

            updatePhotoBtn.addEventListener('click', function() {
                const file = uploadPhotoInput.files[0];
                if (file) {
                    saveImage(file);
                }
            });

            cancelUploadBtn.addEventListener('click', function() {
                modalImg.src = originalPhotoSrc;
                profileImg.src = originalPhotoSrc;
                selectPhotoBtn.style.display = 'inline-block';
                updatePhotoBtn.style.display = 'none';
                cancelUploadBtn.style.display = 'none';
                deletePhotoBtn.style.display = 'inline-block';
                FormUpload.style.width = '0px';
            });

            deletePhotoBtn.addEventListener('click', function() {
                profileImg.src = '/app/Presentation/Assets/Images/default-profile.png';
            });

            function saveImage(file) {
                const formData = new FormData();
                formData.append('photo', file);

                fetch('upload.php', {
                    method: 'POST',
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            originalPhotoSrc = modalImg.src;
                            modal.style.display = 'none';
                            selectPhotoBtn.style.display = 'inline-block';
                            updatePhotoBtn.style.display = 'none';
                            cancelUploadBtn.style.display = 'none';
                            deletePhotoBtn.style.display = 'inline-block';
                        } else {
                            alert('Erro ao atualizar a foto. Por favor, tente novamente.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

            // Modal de Edição de Biografia
            editIcon.addEventListener('click', function() {
                biografiaModal.style.display = 'block';

                // Preencher o modal com os valores atuais
                const currentNome = bioNome.textContent.split(': ')[1];
                const currentTelefone = bioTelefone.textContent.split(': ')[1];
                const currentEmail = bioEmail.textContent.split(': ')[1];

                editNome.value = currentNome;
                editTelefone.value = currentTelefone;
                editEmail.value = currentEmail;
            });

            closeBiografiaBtn.addEventListener('click', function() {
                biografiaModal.style.display = 'none';
            });

            window.addEventListener('click', function(event) {
                if (event.target == biografiaModal) {
                    biografiaModal.style.display = 'none';
                }
            });

            document.getElementById('editBiografiaForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const nome = document.getElementById('editNome').value;
                const telefone = document.getElementById('editTelefone').value;
                const email = document.getElementById('editEmail').value;

                // Atualize a biografia com os novos valores
                bioNome.innerHTML = `<strong>Nome:</strong> ${nome}`;
                bioTelefone.innerHTML = `<strong>Telefone:</strong> ${telefone}`;
                bioEmail.innerHTML = `<strong>Email:</strong> ${email}`;

                biografiaModal.style.display = 'none';
            });
        });
    </script>
</x-layoutClient>
