<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
     /*
        Mostrar um todos
    */
    public function index(Request $request, $id)
    {
        return Comment::where('fk_postagem_id', $id)->get();
    }


    public function store(Request $request, $id)
    {
        $validated = Validator::make($request->all(),[

            'descricao' => ['required', 'max:255'],
            'usuario' => ['required', 'max:20'],
          
        ]);

        if(!$validated->fails()){

            $comment = new Comment;

            $comment->descricao = $request->descricao;
            $comment->usuario = $request->usuario;
            $comment->fk_postagem_id = $request->id;
            

            $comment->save();


            return response()->json([
                "message" => "Comentario criado com sucesso"
            ], 201);

        } else {

        return response()->json([
            "message" => $validated->errors()->all()
        ], 500);

        }   

    }

    /**
     * Mostrar um item
     */
    public function show(Request $request, $id, $id_comentario)
    {
        if (Comment::where('id', $id_comentario)->exists()) {
            $comment = Comment::find($id_comentario);

            if(!($comment->fk_postagem_id == $id)){
                return response($comment, 200)->json([
                    "message" => "Comentario não encontrado no post"
                ], 404);
            }

            return response($comment, 200);
          } else {
            return response()->json([
              "message" => "Comentário não encontrado"
            ], 404);
          }

    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Request $request, $id, $id_comentario)
    {
        if (Comment::where('id', $id_comentario)->exists()) {

            $comment = Comment::find($id_comentario);

            if(!($comment->fk_postagem_id == $id)){
                return response()->json([
                    "message" => "Comentario não encontrado no post"
                ], 404);
            }

            $comment->descricao = ($request->has('descricao')) ? $request->descricao : $comment->descricao;
            $comment->save();

            return response()->json([
                "message" => "Comentario atualizado com sucesso"
            ], 200);

            } else {
            return response()->json([
                "message" => "Comentario não encontrado"
            ], 404);

        }
    }


    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy(Request $request, $id, $id_comentario)
    {
        if(Comment::where('id', $id_comentario)->exists()) {

            $comment = Comment::find($id_comentario);

            if(!($comment->fk_postagem_id == $id)){
                return response()->json([
                    "message" => "Comentario não encontrado na postagem"
                ], 404);
            }

            $comment->delete();

            return response()->json([
              "message" => "Comentário deletado"
            ], 202);
          } else {
            return response()->json([
              "message" => "Comentário não encontrado"
            ], 404);
          }
    }
}
