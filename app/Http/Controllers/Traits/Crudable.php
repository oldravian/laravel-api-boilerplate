<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait Crudable
{

    public function store(Request $request){
        try{          
        DB::beginTransaction();
        $data = $request->input();
        if(method_exists($this->repository , 'storeValidation')){
            $this->repository->storeValidation($data)->validate();   
        }
        $item = $this->repository->store($data);
        DB::commit();
        if(isset($this->resource)){
            return response()->success($this->resource." Created successfully", compact("item"));    

        }
        return response()->success("Item created successfully", compact("item"));
        }
        catch(\Exception $e){
            DB::rollBack();
            DB::commit();
            return $this->handleException($e);
        }
    }

    public function update($id, Request $request){
        try{
        DB::beginTransaction();
        $data = $request->input();
        if(method_exists($this->repository , 'updateValidation')){
            $this->repository->updateValidation($data)->validate();   
        }
        $item = $this->repository->update($id, $data);
        DB::commit();
        if(isset($this->resource)){
            return response()->success($this->resource." updated successfully", compact("item"));    

        }
        return response()->success("Item updated successfully", compact("item"));
        }
        catch(\Exception $e){
            DB::rollBack();
            DB::commit();
            return $this->handleException($e);
        }
    }

    public function destroy($id){
        try{
        $this->repository->delete($id);
        if(isset($this->resource)){
            return response()->success($this->resource." deleted successfully");    

        }
        return response()->success("Item deleted successfully");
        }
        catch(\Exception $e){
            return $this->handleException($e);
        }
    }

    public function index(Request $request){
        try{
        $paginated_items=$this->repository->getPaginated($request->all());
        
        return response()->success("Items fetched successfully", compact("paginated_items"));
        }
        catch(\Exception $e){
            return $this->handleException($e);
        }
    }

    public function show($id){
        try{
        $item=$this->repository->getSingle($id);
        if(isset($this->resource)){
            return response()->success($this->resource." fetched successfully", compact("item"));    

        }

        
        return response()->success("Item fetched successfully", compact("item"));
        }
        catch(\Exception $e){
            return $this->handleException($e);
        }
    }
}
