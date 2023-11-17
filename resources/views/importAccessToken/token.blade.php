<div>
    <a href="/admin"><button class="home">Dashboard</button></a>

</div>
<div class="container">

    <script
        class="amocrm_oauth"
        charset="utf-8"
        data-client-id="xxxx"
        data-title="Button"
        data-compact="false"
        data-class-name="className"
        data-color="default"
        data-state="state"
        data-error-callback="functionName"
        data-mode="popup"
        src="https://www.amocrm.ru/auth/button.min.js"
    ></script>
       <div>
           <form method="post" action="/update_access_token">
               @method('patch')
               @csrf
               <div class="form-container">
                   <label>
                       <input class="code"  type="text"  name="code" placeholder="Add integration key"/>
                   </label>
                   <button class="button">
                       Get Access Token
                   </button>
               </div>
           </form>

       </div>
    @if(session('success'))
        <div id="alert" class="success">
           <span class="filed"> {{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div id="alert" class="danger">
           <span > {{ session('error') }}</span>
        </div>
    @endif
</div>



    <style>
    .success{
        width: auto;
        height: auto;
        background-color: white;
        border: 1px solid #20d220
    }
    .danger{
        width: auto;
        height: auto;
        background-color: white;
        border: 1px solid red
    }
    .container{
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 200px;
    }
    .form-container{
        display: flex;
        align-items: center;
    }
    .container div{
        margin: 15px;
    }
     .code{
     width: 350px;
     height: 50px;
     }
     .button{
         width: 100px;
         height: 50px;
         background-color: #4ba8f3;
         border: #4ba8f3;
     }
     .button:hover{
         background-color: #2487d9;

     }
     #alert{
         margin-top: 150px;
         min-width: 300px;
         height: 47px;
         border-radius: 16px;
        padding: 1px 5px 1px 5px;
        display: flex;
         justify-content: center;
         align-items: center;
     }
     span{
         font-size: 20px;
         color: red;
         font-weight: 600;
     }
    .filed{
        color: #20d220;
    }
    .home{
        margin-top: 20px;
        width: 110px;
        height: 48px;
        background-color: #1f2d3d;
        border: #1f2d3d;
        color: white;
        border-radius: 3px;
    }

    </style>
