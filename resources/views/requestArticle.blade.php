<x-sidemenu-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg centered justify-center">
                <table>
                  <thead>
                    <tr>
                      <th>id</th>
                      <th>Naam</th>
                      <th>Totale hoeveelheid</th>
                      <th>Hoeveelheid uitgeleend</th>
                      <th>Prijs</th>
                      <th>Magazijn</th>
                      <th>Gemaakt</th>
                      <th>Laast geüpdate</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  {{-- Fill table with the contents of $articles (See ArticlesController) --}}
                    @foreach ($articles as $article)
                        <tr>
                          <td>{{ $article->id }}</td>  
                          <td>{{ $article->name }}</td>
                          <td>{{ $article->total_amount }}</td>
                          <td>{{ $article->lent_out }}                          
                          <td>{{ $article->price }}</td>
                          <td>{{ $article->academy_name}}</td>
                          <td>{{ date_format($article->created_at, "Y/m/d")}}</td>
                          <td>{{ date_format($article->updated_at, "Y/m/d")}}</td>
                          <td><button class="basicLinkBtn" onclick="openModal('{{$article->name}}', {{$article->total_amount}}, {{$article->id}})">Vraag aan</button></td>
                          
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                {{-- Request modal --}}
                  <div class="modal hidden" id="modal">
                      <div class="topRow">
                        <h1 id="modalName">artikel naam</h1>
                      </div>

                      <label for="">Uw gegevens:</label>
                      <div class="row">
                        <input type="text" name="userName" id="userName" value="{{Auth::user()->firstName}} {{Auth::user()->infix}} {{Auth::user()->lastName}}" disabled>
                        <input type="text" name="userMail" id="userMail" value="{{Auth::user()->email}}" disabled>
                      </div>
                      <form action="{{route('request.articles')}}" method="post">
                      @csrf <!-- {{ csrf_field() }} -->
                        <br>                      
                          <label for="requestedAmount" id="modalText">Hoeveel artikelnaam wilt u?</label>
                          <input type="number" name="requestedAmount" id="requestedAmount" min=0 max="1" required>
                          <input type="hidden" value="{{Auth::user()->id}}"name="userId">
                          <input type="hidden" value="" name="requestedId" id="requestedId" required>
                        <br>
                        <button class="basicLinkBtn" onclick="closeModal()">Annuleer</button>
                        <button type="submit" class="basicLinkBtn">Vraag aan</button>
                      </form>
                  </div>
                {{-- End request modal --}}
                <div class="overlay hidden"></div>  	
            </div>
        </div>
    </div>
    @push('stylesheets')
    <link rel="stylesheet" href="{{ mix('css/rArticle.css') }}">
    @endpush


    <script>
      const overlay = document.querySelector('.overlay');
      const modalHeader = document.querySelector('#modalName');
      const modalText = document.querySelector('#modalText');
      const modalInput = document.querySelector('#requestedAmount');   
      const modal = document.querySelector('.modal');
      const hiddenId = document.querySelector('#requestedId')
      function closeModal(){
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
      }

      function openModal(articleName, articleMax, articleId){
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        modalHeader.textContent = `Aanvraag voor ${articleName}`
        modalText.textContent=`Hoeveel ${articleName} wilt u?`;
        hiddenId.value=`${articleId}`
        modalInput.max = articleMax;
      }

      overlay.addEventListener('click',() => {
        closeModal();
      });


    </script>
</x-sidemenu-layout>
