@extends('layouts.erp3master')
@section('content')

<style type="text/css">
 .profile-pic {
 
}

.profile-pic:hover .edit {
  display: block;
}

.edit {
  padding-top: 7px; 
  padding-right: 7px;

  right: 0;
  top: 0;
  display: none;
}

</style>

<section class="content-header" style="margin-top: -35px; margin-bottom: 20px">
            <h1>
                Projects
                <small>{!! $page_description ?? "Page description" !!}</small>
            </h1>

            {{ TaskHelper::topSubMenu('topsubmenu.projects')}}
          
        </section>




 
                   

<section class="content">

      <!-- Default box -->


      <div class="card">
        <div class="card-header">

            @if(\Auth::user()->hasRole('admins'))
                        <a class="btn bg-primary btn-sm" href="{!! route('admin.projects.create') !!}" title="{{ trans('admin/projects/general.button.create') }}">
                            <i class="fa fa-plus"></i> Create Project
                        </a>
                      @endif
          

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <form method="GET" action="/admin/projects/search/tasks/">                          
                 <div class="input-group input-group-sm hidden-xs" style="width: 260px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search projects tasks">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                  </div>
                </div>
                </form>
          </div>

        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr class="bg-info">
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Project Name
                      </th>
                      <th style="width: 30%">
                          Team Members
                      </th>
                      <th>
                          Project Progress
                      </th>
                      <th style="width: 8%" class="text-center">
                          Status
                      </th>
                      <th style="width: 20%">
                      </th>
                  </tr>
              </thead>
              <tbody>


                @foreach($projects as $project)
                  <tr>
                      <td>
                          #{{ $project->id }}
                      </td>
                      <td>
                          <a>
                              {!! link_to_route('admin.projects.show', $project->name, [$project->id], []) !!}
                          </a>
                          <br>
                          <small>
                              {{$project->tagline}}
                          </small>
                      </td>
                      <td>
                          <ul class="list-inline">
                              <li class="list-inline-item">
                                  <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar.png">
                              </li>
                              <li class="list-inline-item">
                                  <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar2.png">
                              </li>
                              <li class="list-inline-item">
                                  <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar3.png">
                              </li>
                              <li class="list-inline-item">
                                  <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar04.png">
                              </li>
                          </ul>
                      </td>
                      <td class="project_progress">
                          <div class="progress progress-sm">
                              <div class="progress-bar bg-green" role="progressbar" aria-volumenow="57" aria-volumemin="0" aria-volumemax="100" style="width: 57%">
                              </div>
                          </div>
                          <small>
                              57% Complete
                          </small>
                      </td>
                      <td class="project-state">
                          <span class="badge {{ $project->class}}">{{ $project->status }}</span>
                      </td>
                     
                     <td class="project-actions text-right">
                    
                    @if ( $project->isEditable() || $project->canChangePermissions() )
                        <a class="button1" href="{!! route('admin.projects.edit', $project->id) !!}" title="{{ trans('general.button.edit') }}"><i class="fa fa-edit"></i></a>
                    @else
                        <i class="fa fa-edit text-muted" title="{{ trans('admin/projects/general.error.cant-edit-this-document') }}"></i>
                    @endif

                    @if ( $project->enabled )
                        <a href="{!! route('admin.projects.disable', $project->id) !!}" title="{{ trans('general.button.disable') }}"><i class="fa fa-check-circle enabled"></i></a>
                    @else
                        <a href="{!! route('admin.projects.enable', $project->id) !!}" title="{{ trans('general.button.enable') }}"><i class="fa fa-ban disabled"></i></a>
                    @endif

                    @if ( $project->isDeletable() )
                        <a href="{!! route('admin.projects.confirm-delete', $project->id) !!}" data-toggle="modal" data-target="#modal_dialog" title="{{ trans('general.button.delete') }}"><i class="fa fa-trash deletable"></i></a>
                    @else
                        <i class="fa fa-trash text-muted" title="{{ trans('admin/projects/general.error.cant-delete-this-document') }}"></i>
                    @endif
                    
                </td>
                  </tr>

                  @endforeach
                 
              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </section>
      <!-- /.card -->

   



@endsection


<!-- Optional bottom section for modals etc... -->
@section('body_bottom')






    

@endsection
