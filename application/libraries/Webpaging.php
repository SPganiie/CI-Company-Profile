<?php if(!defined('BASEPATH')) exit('No direct access script allowed');

class Webpaging
{
    var $CI = NULL;
    public $set;
    public $kode;
    public $select;

    function __construct()
    {
        $this->CI =& get_instance();
    }

    // Select query pagination
    function select($select = '*')
    {
        $this->select = ' '. $select;
    }

    // Config pagination
    function config($table = NULL, $page = '1', $jml = '20')
    {
        // Get halaman dan jml halaman
        $page   = ($page == '') ? '1' : $page;
        $page   = $page-1;
        $dari   = $page*$jml;

        // Query data dengan limit
                  $this->CI->db->limit($jml, $dari);
        $get    = $this->CI->db->select('SQL_CALC_FOUND_ROWS' . (isset($this->select) ? $this->select : ' *'), FALSE)->get($table)->result();

        // Menghitung jumlah data tanpa limit
        $count  = $this->CI->db->query("SELECT FOUND_ROWS() AS `count`")->row()->count;

        // Set setting pagination
        $this->set = $count .'|'. $jml .'|'. $page;

        return $get;
    }

    // Create pagination
    function create($ajax = TRUE, $index = null, $bid = 'primarycontent', $qry = null)
    {
        // $index  = ($index == null) ? 'index' : $index;
        $ajax   = ($ajax == null) ? TRUE : $ajax;
        $bid    = ($bid == null) ? 'primarycontent' : $bid;

        // Memecah data config
        $set    = $this->set;
        $data   = explode('|', $set);

        // Set halaman
        $page   = $data[2];
        $pg     = $data[2]+1;

        // Menghitung berapa pagiantionya
        $hal    = ceil($data[0]/$data[1]);

        // Menselect data yang dikirim lewat url
        $link   = str_replace(base_url(), '', current_url());
        // $batas  = explode('/'.$index, $link);
        // $link   = $batas[0];

        // Menselect get data
        $ask        = explode('?', $_SERVER['REQUEST_URI']);
        $link_ask   = (isset($ask[1])) ? '?'.$ask[1] : '';

        // Membatasi jumlah pagination
        if($hal < 7)
        {
            $min = '1';
            $max = $hal;
        }
        else
        {
            $min = ($page > 3) ? $page-3 : '1';
            $max = ($page >= $hal-3) ? $hal : $page+3;
        }

        if($qry == null)
        {
            // Jika menggunakan ajax
            if($ajax == TRUE)
            {
                $start  = '';//'<li class="previous '. ($pg == '1' ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'aksi("'. $link .''. $index .'1'. $link_ask .'", "' . $bid . '")\' ><span aria-hidden="true">&larr;</span></a> </li>';
                $prev   = '<li class="'. ($pg == '1' ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'aksi("'. $link .''. $index .''. ($page) . $link_ask.'", "' . $bid . '")\' >Prev</a>  </li>';
                $last   = '';//'<li class="next '. ($pg == $hal ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'aksi("'. $link .''. $index .''. $hal . $link_ask.'", "' . $bid . '")\' ><span aria-hidden="true">&rarr;</span></a> </li>';
                $next   = '<li class="'. ($pg == $hal ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'aksi("'. $link .''. $index .''. ($pg+1) . $link_ask.'", "' . $bid . '")\' >Next</a> </li>';

                $paging = '';

                for($a=$min; $a<=$max;$a++)
                {
                    $paging .= '<li class="'. ($pg == $a ? 'active' : '') .'" ><a href="javascript:void(0);" onClick=\'aksi("'. $link .''. $index .''. $a . $link_ask .'", "' . $bid . '")\' ><b>'. $a .'</b></a></li>';
                }
            }
            // Jika tidak menggunakan ajax
            elseif($ajax == FALSE)
            {
                $start  = '';//'<li class="previous '. ($pg == '1' ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $index .'/1'. $link_ask .'"\' ><span aria-hidden="true">&larr;</span></a> </li>';
                $prev   = '<li class="'. ($pg == '1' ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $index .'/'. ($page) . $link_ask.'"\' >Prev</a> </li>';
                $last   = '';//'<li class="next '. ($pg == $hal ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $index .'/'. $hal . $link_ask.'"\' ><span aria-hidden="true">&rarr;</span></a> </li>';
                $next   = '<li class="'. ($pg == $hal ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $index .'/'. ($pg+1) . $link_ask.'"\' >Next</a> </li>';

                $paging = '';

                for($a=$min; $a<=$max; $a++)
                {
                    $paging .= '<li class="'. ($pg == $a ? ' active' : '') .'"> <a href="javascript:void(0);" onClick=\'location.href="'. base_url() . $link .'/'. $index .'/'. $a . $link_ask .'"\' class=""><b>'. $a .'</b></a> </li>';
                }
            }
        }
        /*
        else
            {
                $link_ask   = preg_replace('#'. $qry .'=([0-9])#', '', $link_ask);
                $link_ask   = preg_replace('#[&]+#', '', $link_ask);
                $link_ask   = ($link_ask == '') ? '?'. $qry .'=' : $link_ask .'&'. $qry .'=';
                $link_ask   = str_replace('?&', '?', $link_ask);

                // Jika menggunakan ajax
                if($ajax == TRUE)
                {
                    $start  = '<li class="previous  '. ($pg == '1' ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'aksi("'. $link .'/'. $link_ask .'1", "' . $bid . '")\' ><span aria-hidden="true">&larr;</span></a> </li>';
                    $prev   = '<li class="'. ($pg == '1' ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'aksi("'. $link .'/'. $link_ask . ($page) .'", "' . $bid . '")\' >Prev</a>  </li>';
                    $last   = '<li class="next '. ($pg == $hal ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'aksi("'. $link .'/'. $link_ask . $hal .'", "' . $bid . '")\' ><span aria-hidden="true">&rarr;</span></a> </li>';
                    $next   = '<li class="'. ($pg == $hal ? ' disabled' : '') .'"> <a href="javascript:void(0);" onClick=\'aksi("'. $link .'/'. $link_ask . ($pg+1) .'", "' . $bid . '")\' >Next</a> </li>';

                    $paging = '';

                    for($a=$min; $a<=$max;$a++)
                    {
                        $paging .= '<li class="'. ($pg == $a ? ' active' : '') .'"> <a href="javascript:void(0);" onClick=\'aksi("'. $link .'/'. $link_ask . $a .'", "' . $bid . '")\' class=" "><b>'. $a .'</b></a> </li>';
                    }
                }
                // Jika tidak menggunakan ajax
                elseif($ajax == FALSE)
                {
                    $start  = '<li class="previous '. ($pg == '1' ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $link_ask .'1"\' ><span aria-hidden="true">&larr;</span></a> </li>';
                    $prev   = '<li class="'. ($pg == '1' ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $link_ask . ($page) .'"\' >Prev</a>  </li>';
                    $last   = '<li class="next '. ($pg == $hal ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $link_ask . $hal .'"\' ><span aria-hidden="true">&rarr;</span></a> </li>';
                    $next   = '<li class="'. ($pg == $hal ? ' disabled' : '') .'" > <a href="javascript:void(0);" onClick=\'location.href="'. base_url().$link .'/'. $link_ask . ($pg+1) .'"\' >Next</a> </li>';

                    $paging = '';

                    for($a=$min; $a<=$max; $a++)
                    {
                        $paging .= '<li class="'. ($pg == $a ? ' active' : '') .'" > <a href="javascript:void(0);" onClick=\'location.href="'. base_url() . $link . $link_ask . $a .'"\' ><b>'. $a .'</b></a> </li>';
                    }
                }
            }
        */

        return ($data[0] <= $data[1]) ? '' : '<nav><ul class="pagination pager">'.$start.$prev .' '. $paging .' '. $next.$last.'</ul></nav>';
    }

    function nomor()
    {
        $set    = $this->set;
        $data   = explode('|', $set);

        $page   = $data[2];

        $no     = ($page*$data[1])+1;

        return $no;
    }

}
