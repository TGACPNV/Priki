@extends('layout')

@section('content')

 <!-- Page content-->
 <div class="container mt-5">
  <div class="row">
   <div class="col-lg-8">
     <!-- Post content-->

     <article>
         @if ($error != false)
         <div class="alert alert-danger" role="alert">
            {{$error}}
          </div>
         @endif
        <!-- Post content-->
        <div class="mb-5">
        <div class="is-flex is-flex-direction-row">
             <h1 class="title">{{ $practice->title }}</h1>
             <!-- TODO: Faire fonctionner les Policies -->
             @can('edit',[\Illuminate\Support\Facades\Auth::user(),$practice])}}
             <div class="ml-4">
                     <div id="btnEditTitle">
                                  <i class="fas fa-edit fa-2x"></i>
                     </div>
            @endcan


             </div>
        </div>
        <form hidden id='editTitleFormGroup' method="POST" action="/practices/4/editTitle" class="border border-secondary rounded p-4 mb-4">
            @csrf
            <input hidden name="id" value="{{ $practice->id }}">
            <div class="form-group row">
                     <label for="newTitle" class="col-sm-2 col-form-label">New title :</label>
                     <div class="col-sm-10">
                                  <input name="newtitle" type="text" class="form-control" id="newTitle"
                                                       placeholder="New Title" value="{{ $practice->title }}" pattern=".{3,40}" required title="3 characters minimum and 40 maximum">
                     </div>
             </div>
             <div class="form-group row">
                     <label for="Reason" class="col-sm-2 col-form-label">Reason :</label>
                     <div class="col-sm-10">
                                  <input name="reason" type="text" class="form-control" id="Reason" placeholder="Reason">
                     </div>
             </div>
             <button type="submit" class="btn btn-primary">{{__('forms.submit')}}</button>
        </form>
    </div>
        <section class="mb-5">
             <p class="fs-5 mb-4">{{ $practice->description }}</p>
        </section>
     </article>

     <!-- Comments section-->
     <section class="mb-5">
        <div class="card bg-light">
             <div class="card-body">
                     @if (\Illuminate\Support\Facades\Auth::check())
                                  <!-- Comment form-->
                                  <form class="mb-4">
                                                       <textarea class="form-control" rows="3" name="comment"
                                                                                         placeholder="Join the discussion and leave a comment!"></textarea>
                                  </form>
                     @endif
                     @foreach ($practice->opinions as $opinion)
                                  <!-- Comment with nested comments-->
                                  <div class="d-flex mb-4">
                                                       <!-- Parent comment-->
                                                       <div class="flex-shrink-0"><img class="rounded-circle"
                                                                                                                                                src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." />
                                                       </div>
                                                       <div class="ms-3 w-100 accordion-header" id="opinion{{ $opinion->id }}">
                                                                                         <a href="/user/{{ $opinion->user->id }}/profile">
                                                                                                                                                <div class="fw-bold">{{ $opinion->user->fullname }}</div>
                                                                                         </a>
                                                                                         {{ $opinion->description }}


                                                                                         <div class="mt-2 is-flex is-flex-direction-row justify-content-between">
                                                                                                                                                <div class="fw-light">
                                                                                                                                                                                                                                         {{ \Carbon\Carbon::parse($opinion->created_at)->isoFormat('D MMMM YYYY') }}
                                                                                                                                                </div>
                                                                                                                                                <div class="fw-light"></div>
                                                                                                                                                <div class="mt-2 is-flex is-flex-direction-row">
                                                                                                                                                                                                                                         <div class="p-2 is-size-7 mr-2 accordion-button collapsed "
                                                                                                                                                                                                                                                                                                                                                                                         data-bs-toggle="collapse" data-bs-target="#comments{{ $opinion->id }}"
                                                                                                                                                                                                                                                                                                                                                                                         aria-expanded="false" aria-controls="comments{{ $opinion->id }}">
                                                                                                                                                                                                                                                                                                                                                                                         {{ $opinion->comments->count() }}
                                                                                                                                                                                                                                                                                                                                                                                         {{ __('practice.comments') }}
                                                                                                                                                                                                                                         </div>
                                                                                                                                                                                                                                         <div class="mr-2 accordion-button collapsed is-size-7"
                                                                                                                                                                                                                                                                                                                                                                                         data-bs-toggle="collapse" data-bs-target="#refs{{ $opinion->id }}"
                                                                                                                                                                                                                                                                                                                                                                                         aria-expanded="false" aria-controls="refs{{ $opinion->id }}">
                                                                                                                                                                                                                                                                                                                                                                                         {{ __('practice.references') }}
                                                                                                                                                                                                                                         </div>
                                                                                                                                                                                                                                         <div class="text-success mr-2">
                                                                                                                                                                                                                                                                                                                                                                                         <i class="fas fa-arrow-up"></i> {{ $opinion->sumUpVotes() }}
                                                                                                                                                                                                                                         </div>
                                                                                                                                                                                                                                         <div class="text-danger">
                                                                                                                                                                                                                                                                                                                                                                                         <i class="fas fa-arrow-down"></i> {{ $opinion->sumDownVotes() }}
                                                                                                                                                                                                                                         </div>
                                                                                                                                                                                                                                         <div>

                                                                                                                                                                                                                                         </div>

                                                                                                                                                </div>
                                                                                         </div>
                                                                                         <!-- Child comments-->
                                                                                         <div id="comments{{ $opinion->id }}" class="accordion-collapse collapse"
                                                                                                                                                aria-labelledby="opinion{{ $opinion->id }}">
                                                                                                                                                @foreach ($opinion->comments as $commentUser)
                                                                                                                                                                                                                                         <div class="is-flex justify-content-between w-100">
                                                                                                                                                                                                                                                                                                                                                                                         <div class="d-flex mt-4">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <div class="flex-shrink-0"><img class="rounded-circle"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             src="https://dummyimage.com/50x50/ced4da/6c757d.jpg"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             alt="..." /></div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <div class="ms-3">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <a href="/user/{{ $commentUser->id }}/profile">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <div class="fw-bold">{{ $commentUser->fullname }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           {{ $commentUser->comment->comment }}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  </div>
                                                                                                                                                                                                                                                                                                                                                                                         </div>
                                                                                                                                                                                                                                                                                                                                                                                         <div class="is-flex is-align-items-center">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @if ($commentUser->comment->points == 1)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <i class="far fa-thumbs-up fa-2x"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @if ($commentUser->comment->points == 0)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <i class="far fa-meh fa-2x"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @if ($commentUser->comment->points == -1)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <i class="far fa-thumbs-down fa-2x"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  @endif
                                                                                                                                                                                                                                                                                                                                                                                         </div>
                                                                                                                                                                                                                                         </div>

                                                                                                                                                @endforeach
                                                                                         </div>
                                                                                         <div id="refs{{ $opinion->id }}" class="accordion-collapse collapse w-100"
                                                                                                                                                aria-labelledby="opinion{{ $opinion->id }}">
                                                                                                                                                <table class="table table-striped w-100">
                                                                                                                                                                                                                                         <tr>
                                                                                                                                                                                                                                                                                                                                                                                         <th class="w-50">Title</th>
                                                                                                                                                                                                                                                                                                                                                                                         <th class="w-50">URL</th>
                                                                                                                                                                                                                                         </tr>
                                                                                                                                                                                                                                         @foreach ($opinion->references as $reference)
                                                                                                                                                                                                                                                                                                                                                                                         <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <td>{{ $reference->description }}</td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <td><a href="{{ $reference->url }}">{{ $reference->url }}</a></td>
                                                                                                                                                                                                                                                                                                                                                                                         </tr>
                                                                                                                                                                                                                                         @endforeach
                                                                                                                                                </table>
                                                                                         </div>
                                                       </div>
                                  </div>
                     @endforeach
             </div>
        </div>
     </section>
   </div>
   <!-- Side widgets-->
   <div class="col-lg-4">
     <!-- Categories widget-->
     <div class="card mb-4">
        <div class="card-header">Infos</div>
        <div class="card-body">
             <div class="row">
                     <table class="m-1 ml-3">
                                  <tr>
                                                       <td class="col-sm-6">{{ __('practice.author') }}</td>
                                                       <td class="col-sm-6">{{ $practice->user->fullname }}</td>
                                  </tr>
                                  <tr>
                                                       <td class="col-sm-6">{{ __('practice.domain') }}</td>
                                                       <td class="col-sm-6">{{ $practice->domain->name }}</td>
                                  </tr>
                                  <tr>
                                                       <td class="col-sm-6">{{ __('practice.created_at') }}</td>
                                                       <td class="col-sm-6">
                                                                                         {{ \Carbon\Carbon::parse($practice->created_at)->isoFormat('D MMMM YYYY') }}
                                                       </td>
                                  </tr>
                                  <tr>
                                                       <td class="col-sm-6">{{ __('practice.updated_at') }}</td>
                                                       <td class="col-sm-6">
                                                                                         {{ \Carbon\Carbon::parse($practice->updated_at)->isoFormat('D MMMM YYYY') }}
                                                       </td>
                                  </tr>
                                  <tr>
                                                       <td class="col-sm-6">{{ __('practice.status') }}</td>
                                                       <td class="col-sm-6">{{ $practice->publicationState->name }}</td>
                                  </tr>
                     </table>
             </div>
        </div>
     </div>

   </div>
  </div>
 </div>
 <script src="/js/practice.js">
@endsection
