<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Artigo;

class SearchController extends Controller
{
    public function formSubmit(Request $post){

        // Salva a palavra a ser pesquisada
        $busca = $post->input('busca');

        // Armazena ID do usuário atual
        $userId = Auth::id();

        // Seta a URL
        $url = "https://www.questmultimarcas.com.br/estoque?termo=$busca";

        $data = $this->curl($url);

        // Seta variáveis de início e fim para função scrape
        $start = '<div id="pixad-listing" class="list"';
        $end = '<ul class="pagination">';

        $scrapeData = $this->scrape($data, $start, $end);

        // Faz um array com cada item da lista separado
        $articles = explode('<div class="card__inner">', $scrapeData);

        // Mensagem para retorno
        $msg = 'Nenhum artigo foi salvo.';

        // Separa os dados de cada item
        foreach($articles as $article){
            $linkname = $this->scrape($article, '">', '</a></h2>');
            $link = $this->scrape($linkname, 'href="', '">');            
            $nome = str_replace('>', '', stristr($linkname, '>'));

            // Descrição dos itens
            $descs = $this->scrape($article, 'class="card__list list-unstyled"', '</ul>');
            $descs = explode('<li class="card-list__row">', $descs);
            
            $i = 1;

            // Monta array com todas as descrições
            foreach($descs as $desc){
                $arrayDesc[$i] = $this->scrape($desc, 'card-list__info">', '</span>');  
                $i++; 
            }

            // Armazena dados em suas respectivas variáveis
            $ano = array_key_exists(2, $arrayDesc) ? $arrayDesc[2] : null; 
            $km = array_key_exists(3, $arrayDesc) ? $arrayDesc[3] : null; 
            $combustivel = array_key_exists(4, $arrayDesc) ? $arrayDesc[4] : null;
            $cambio = array_key_exists(5, $arrayDesc) ? $arrayDesc[5] : null;
            $portas = array_key_exists(6, $arrayDesc) ? $arrayDesc[6] : null;
            $cor = array_key_exists(7, $arrayDesc) ? $arrayDesc[7] : null;

            if(!$link == null){
                $this->store($userId, $link, $nome, $ano, $km, $combustivel, $cambio, $portas, $cor);
                $msg = "Artigos salvos.";
            }
        }

        return $msg;
    }

    public function curl($url){

        // Inicia o CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }

    public function scrape($data, $start, $end){
        $data = stristr($data, $start);
        $data = substr($data, strlen($start));
        $stop = stripos($data, $end);
        $data = substr($data, 0, $stop);

        return $data;
    }

    public function store($userId, $link, $nome, $ano, $km, $combustivel, $cambio, $portas, $cor){
        
        $artigo = new Artigo;

        $artigo->user_id = $userId;
        $artigo->nome_veiculo = $nome;
        $artigo->link = $link;
        $artigo->ano = (int)$ano;
        $artigo->combustivel = trim($combustivel);
        $artigo->portas = trim($portas);
        $artigo->km = (float)$km;
        $artigo->cambio = trim($cambio);
        $artigo->cor = trim($cor);

        $artigo->save();
        
    }
}
