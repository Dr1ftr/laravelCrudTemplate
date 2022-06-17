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
                      <th>Gemaakt</th>
                      <th>Laast geüpdate</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($articles as $article)
                        <tr>
                          <td>{{ $article->id }}</td>  
                          <td>{{ $article->name }}</td>
                          <td>{{ $article->total_amount }}</td>
                          <td>{{ $article->lent_out }}
                          <td>{{ $article->price }}</td>
                          <td>{{ date_format($article->created_at, "Y/m/d")}}</td>
                          <td>{{ date_format($article->updated_at, "Y/m/d")}}</td>
                          <td><button class="basicLinkBtn">Details</button></td> 
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('stylesheets')
    <link rel="stylesheet" href="{{ mix('css/rArticle.css') }}">
    @endpush
</x-sidemenu-layout>
