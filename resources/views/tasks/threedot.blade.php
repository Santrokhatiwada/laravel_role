<style>
#threeDot {
                                    margin-left: 2px;

                                }

</style>
<i id="threeDot" class="fas fa-ellipsis-vertical" data-bs-toggle="dropdown" aria-expanded="false"></i>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <span class="dropdown-item">
                                                                            <a href="{{ route('tasks.edit',$task->id) }}">
                                                                                <i class="fas fa-pen mx-2"></i> 
                                                                                <button class="btn btn-primary">Update</button>
                                                                            </a>
                                                                        </span>
                                                                    </li>
                                                                    <li>
                                                                        <span class="dropdown-item">
                                                                            @can('task-delete')
                                                                            <i class="fas fa-trash mx-2"></i>
                                                                            {!! Form::open(['method' => 'DELETE','route' => ['tasks.destroy', $task->id],'style'=>'display:inline']) !!}
                                                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                                            {!! Form::close() !!}
                                                                            @endcan
                                                                            
                                                                            </a>
                                                                        </span>
                                                                    </li>
                                                                </ul>
                                                                </i>